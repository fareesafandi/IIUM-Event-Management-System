<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterEventRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * Display all events the authenticated user has registered for.
     *
     * @return View
     */
    public function myEvents(): View
    {
        $user = auth()->user();

        $registrations = $user->registeredEvents()
            ->with(['manager', 'categories'])
            ->orderByPivot('created_at', 'desc')
            ->paginate(12);

        return view('registrations.my-events', compact('registrations'));
    }

    /**
     * Register the authenticated user for an event.
     *
     * @param RegisterEventRequest $request
     * @param Event $event
     * @return RedirectResponse
     */
    public function register(RegisterEventRequest $request, Event $event): RedirectResponse
    {
        $user = auth()->user();
        $validated = $request->validated();

        // Check if event can accept registrations
        if (!$event->canAcceptRegistrations()) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Sorry, this event is no longer accepting registrations.');
        }

        // Check if user is already registered
        if ($user->hasRegisteredForEvent($event->id)) {
            return redirect()->route('events.show', $event)
                ->with('error', 'You have already registered for this event.');
        }

        // Check if event is full
        if ($event->isFull()) {
            // Update event status to full
            $event->update(['status' => Event::STATUS_FULL]);

            return redirect()->route('events.show', $event)
                ->with('error', 'Sorry, this event is full.');
        }

        // Register user for event
        try {
            DB::beginTransaction();

            // Attach user to event with registration details
            $user->registeredEvents()->attach($event->id, [
                'status' => 'pending',
            ]);

            // Update event status if it becomes full
            if ($event->max_participants !== null) {
                $confirmedCount = $event->confirmed_participants_count;
                if ($confirmedCount >= $event->max_participants) {
                    $event->update(['status' => Event::STATUS_FULL]);
                }
            }

            DB::commit();

            return redirect()->route('events.show', $event)
                ->with('success', 'Successfully registered for the event!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('events.show', $event)
                ->with('error', 'An error occurred while registering. Please try again.');
        }
    }

    /**
     * Unregister the authenticated user from an event.
     *
     * @param Event $event
     * @return RedirectResponse
     */
    public function unregister(Event $event): RedirectResponse
    {
        $user = auth()->user();

        // Check if user is registered
        if (!$user->hasRegisteredForEvent($event->id)) {
            return redirect()->route('events.show', $event)
                ->with('error', 'You are not registered for this event.');
        }

        // Check if event date has passed
        if ($event->isPast()) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Cannot unregister from past events.');
        }

        try {
            DB::beginTransaction();

            // Detach user from event
            $user->registeredEvents()->detach($event->id);

            // Update event status if it was full and now has available slots
            if ($event->status === Event::STATUS_FULL) {
                if (!$event->isFull()) {
                    $event->update(['status' => Event::STATUS_OPEN]);
                }
            }

            DB::commit();

            return redirect()->route('events.show', $event)
                ->with('success', 'Successfully unregistered from the event.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('events.show', $event)
                ->with('error', 'An error occurred while unregistering. Please try again.');
        }
    }
}
