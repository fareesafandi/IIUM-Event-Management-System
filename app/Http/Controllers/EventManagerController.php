<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventManagerController extends Controller
{
    /**
     * Display the event manager dashboard.
     *
     * @return View
     */
    public function dashboard(): View
    {
        $user = auth()->user();

        $totalEvents = $user->managedEvents()->count();
        $upcomingEvents = $user->managedEvents()
            ->upcoming()
            ->whereIn('status', [Event::STATUS_OPEN, Event::STATUS_UPCOMING])
            ->count();
        $pastEvents = $user->managedEvents()->past()->count();

        $recentEvents = $user->managedEvents()
            ->with(['categories', 'participants'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('manager.dashboard', compact('totalEvents', 'upcomingEvents', 'pastEvents', 'recentEvents'));
    }

    /**
     * Display a listing of events managed by the authenticated user.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $user = auth()->user();

        $query = $user->managedEvents()
            ->with(['categories', 'participants']);

        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        $events = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('manager.events.index', compact('events', 'categories'));
    }

    /**
     * Show the form for creating a new event.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('manager.events.create', compact('categories'));
    }

    /**
     * Store a newly created event in storage.
     *
     * @param StoreEventRequest $request
     * @return RedirectResponse
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            // Handle poster image upload
            if ($request->hasFile('poster_image')) {
                $image = $request->file('poster_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('events/posters', $imageName, 'public');
                $validated['poster_image'] = $imagePath;
            } elseif ($request->has('poster_image_url')) {
                // Allow URL for poster image
                $validated['poster_image'] = $request->poster_image_url;
            }

            // Set manager_id to authenticated user
            $validated['manager_id'] = auth()->id();

            // Create event
            $event = Event::create($validated);

            // Attach categories if provided
            if (isset($validated['categories']) && is_array($validated['categories'])) {
                $event->categories()->sync($validated['categories']);
            }

            DB::commit();

            return redirect()->route('manager.events.index')
                ->with('success', 'Event created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded image if transaction failed
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while creating the event. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified event.
     *
     * @param Event $event
     * @return View
     */
    public function edit(Event $event): View
    {
        // Ensure user owns this event
        if ($event->manager_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $event->load('categories');
        $categories = Category::orderBy('name')->get();

        return view('manager.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified event in storage.
     *
     * @param UpdateEventRequest $request
     * @param Event $event
     * @return RedirectResponse
     */
    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            // Handle poster image upload
            $oldImagePath = $event->poster_image;
            $newImagePath = null;

            if ($request->hasFile('poster_image')) {
                $image = $request->file('poster_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $newImagePath = $image->storeAs('events/posters', $imageName, 'public');
                $validated['poster_image'] = $newImagePath;

                // Delete old image if it exists and is in storage (not URL)
                if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            } elseif ($request->has('poster_image_url')) {
                // Allow URL for poster image
                $validated['poster_image'] = $request->poster_image_url;

                // Delete old image if it exists and is in storage (not URL)
                if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            } else {
                // Keep existing image if not changed
                unset($validated['poster_image']);
            }

            // Update event
            $event->update($validated);

            // Sync categories
            if (isset($validated['categories']) && is_array($validated['categories'])) {
                $event->categories()->sync($validated['categories']);
            } else {
                $event->categories()->detach();
            }

            // Auto-update status if event becomes full
            if ($event->max_participants !== null && $event->isFull() && $event->status !== Event::STATUS_FULL) {
                $event->update(['status' => Event::STATUS_FULL]);
            }

            DB::commit();

            return redirect()->route('manager.events.index')
                ->with('success', 'Event updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete newly uploaded image if transaction failed
            if ($newImagePath && Storage::disk('public')->exists($newImagePath)) {
                Storage::disk('public')->delete($newImagePath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while updating the event. Please try again.');
        }
    }

    /**
     * Remove the specified event from storage.
     *
     * @param Event $event
     * @return RedirectResponse
     */
    public function destroy(Event $event): RedirectResponse
    {
        // Ensure user owns this event
        if ($event->manager_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            // Delete poster image if exists
            if ($event->poster_image && Storage::disk('public')->exists($event->poster_image)) {
                Storage::disk('public')->delete($event->poster_image);
            }

            // Delete event (cascade will handle related records)
            $event->delete();

            DB::commit();

            return redirect()->route('manager.events.index')
                ->with('success', 'Event deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('manager.events.index')
                ->with('error', 'An error occurred while deleting the event. Please try again.');
        }
    }

    /**
     * Display the list of participants for the specified event.
     *
     * @param Event $event
     * @return View
     */
    public function participants(Event $event): View
    {
        // Ensure user owns this event
        if ($event->manager_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $participants = $event->participants()
            ->orderByPivot('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => $event->participants()->count(),
            'confirmed' => $event->participants()->wherePivot('status', 'confirmed')->count(),
            'pending' => $event->participants()->wherePivot('status', 'pending')->count(),
            'cancelled' => $event->participants()->wherePivot('status', 'cancelled')->count(),
        ];

        return view('manager.events.participants', compact('event', 'participants', 'stats'));
    }

    /**
     * Update the status of a participant for the specified event.
     *
     * @param Request $request
     * @param Event $event
     * @param User $user
     * @return RedirectResponse
     */
    public function updateParticipantStatus(Request $request, Event $event, User $user): RedirectResponse
    {
        // Ensure user owns this event
        if ($event->manager_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        // Check if user is registered for this event
        if (!$user->hasRegisteredForEvent($event->id)) {
            return redirect()->route('manager.events.participants', $event)
                ->with('error', 'User is not registered for this event.');
        }

        try {
            DB::beginTransaction();

            // Update participant status
            $event->participants()->updateExistingPivot($user->id, [
                'status' => $validated['status'],
            ]);

            // Auto-update event status based on confirmed participants
            if ($event->max_participants !== null) {
                if ($event->isFull() && $event->status !== Event::STATUS_FULL) {
                    $event->update(['status' => Event::STATUS_FULL]);
                } elseif (!$event->isFull() && $event->status === Event::STATUS_FULL) {
                    $event->update(['status' => Event::STATUS_OPEN]);
                }
            }

            DB::commit();

            return redirect()->route('manager.events.participants', $event)
                ->with('success', 'Participant status updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('manager.events.participants', $event)
                ->with('error', 'An error occurred while updating participant status. Please try again.');
        }
    }
}
