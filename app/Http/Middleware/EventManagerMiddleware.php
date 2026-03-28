<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Ensures that the authenticated user has the 'event_manager' role.
     * Redirects to home page with an error message if the user is not an event manager.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        // Allow access to users who are event managers or admins
        if (! (auth()->user()->isEventManager() || (method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin())) ) {
            return redirect()->route('home')
                ->with('error', 'You do not have permission to access this page. Only event managers or admins are allowed.');
        }

        return $next($request);
    }
}
