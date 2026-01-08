<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of events (homepage and events index).
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Event::query()
            ->with(['manager', 'categories', 'participants'])
            ->upcoming()
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc');

        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        } else {
            // Default: show open and upcoming events
            $query->whereIn('status', [Event::STATUS_OPEN, Event::STATUS_UPCOMING]);
        }

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Paginate results
        $events = $query->paginate(12)->withQueryString();

        // Get all categories for filter sidebar
        $categories = Category::orderBy('name')->get();

        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Search events by keyword.
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request): View
    {
        $request->validate([
            'q' => 'required|string|min:2|max:255',
        ]);

        $searchTerm = $request->q;

        $events = Event::query()
            ->with(['manager', 'categories', 'participants'])
            ->search($searchTerm)
            ->upcoming()
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('events.index', compact('events', 'categories', 'searchTerm'));
    }

    /**
     * Filter events by category and/or status.
     *
     * @param Request $request
     * @return View
     */
    public function filter(Request $request): View
    {
        $query = Event::query()
            ->with(['manager', 'categories', 'participants'])
            ->upcoming();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $category = Category::where('slug', $request->category)
                ->orWhere('id', $request->category)
                ->first();

            if ($category) {
                $query->byCategory($category->id);
            }
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        } else {
            $query->whereIn('status', [Event::STATUS_OPEN, Event::STATUS_UPCOMING]);
        }

        // Additional search if provided
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        $events = $query
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Display the specified event.
     *
     * @param Event $event
     * @return View
     */
    public function show(Event $event): View
    {
        // Eager load relationships
        $event->load(['manager', 'categories', 'participants']);

        // Check if authenticated user has registered for this event
        $isRegistered = false;
        $registrationStatus = null;
        if (auth()->check()) {
            $registration = $event->participants()
                ->where('users.id', auth()->id())
                ->first();

            if ($registration) {
                $isRegistered = true;
                $registrationStatus = $registration->pivot->status;
            }
        }

        // Check if user is the event manager
        $isManager = false;
        if (auth()->check()) {
            $isManager = $event->manager_id === auth()->id();
        }

        // Get related events (same category, upcoming)
        $relatedEvents = Event::query()
            ->where('id', '!=', $event->id)
            ->whereHas('categories', function ($q) use ($event) {
                $q->whereIn('categories.id', $event->categories->pluck('id'));
            })
            ->upcoming()
            ->where('status', Event::STATUS_OPEN)
            ->limit(4)
            ->get();

        return view('events.show', compact('event', 'isRegistered', 'registrationStatus', 'isManager', 'relatedEvents'));
    }
}
