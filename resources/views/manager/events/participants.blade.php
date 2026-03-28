@extends('layouts.app')

@section('title', 'Event Participants - ' . $event->title)

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Event Participants</h1>
                <p class="text-gray-600 text-lg">{{ $event->title }}</p>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <a href="{{ route('events.show', $event) }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-100 text-gray-800 border border-gray-300 font-medium rounded-md transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View Event
                </a>
                <a href="{{ route('manager.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-100 text-gray-800 border border-gray-300 font-medium rounded-md transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-md p-2">
                            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500 ">Total</p>
                            <p class="text-xl font-semibold text-gray-900 ">{{ $stats['total'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-md p-2">
                            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500 ">Confirmed</p>
                            <p class="text-xl font-semibold text-gray-900 ">{{ $stats['confirmed'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 rounded-md p-2">
                            <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500 ">Pending</p>
                            <p class="text-xl font-semibold text-gray-900 ">{{ $stats['pending'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-100 rounded-md p-2">
                            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500 ">Cancelled</p>
                            <p class="text-xl font-semibold text-gray-900 ">{{ $stats['cancelled'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Info Card -->
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 ">Event Date</p>
                        <p class="text-lg font-semibold text-gray-900 ">
                            {{ $event->date->format('l, F d, Y') }}
                        </p>
                        <p class="text-sm text-gray-600 ">
                            {{ date('g:i A', strtotime($event->time)) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 ">Venue</p>
                        <p class="text-lg font-semibold text-gray-900 ">{{ $event->venue }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 ">Participants</p>
                        <p class="text-lg font-semibold text-gray-900 ">
                            @if($event->max_participants)
                                {{ $event->confirmed_participants_count }} / {{ $event->max_participants }}
                                @if($event->available_slots !== null)
                                    <span class="text-sm text-gray-600 ">
                                        ({{ $event->available_slots }} remaining)
                                    </span>
                                @endif
                            @else
                                {{ $event->confirmed_participants_count }} registered
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Participants Table -->
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 ">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <h3 class="text-lg font-semibold text-gray-900 ">Participants List</h3>
                        
                        <!-- Status Filter Tabs -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('manager.events.participants', ['event' => $event]) }}" 
                               class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ !request('status') ? 'bg-indigo-100 text-indigo-700 ' : 'text-gray-600 hover:bg-gray-100  ' }}">
                                All ({{ $stats['total'] }})
                            </a>
                            <a href="{{ route('manager.events.participants', ['event' => $event, 'status' => 'pending']) }}" 
                               class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ request('status') == 'pending' ? 'bg-yellow-100 text-yellow-700 ' : 'text-gray-600 hover:bg-gray-100  ' }}">
                                Pending ({{ $stats['pending'] }})
                            </a>
                            <a href="{{ route('manager.events.participants', ['event' => $event, 'status' => 'confirmed']) }}" 
                               class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ request('status') == 'confirmed' ? 'bg-green-100 text-green-700 ' : 'text-gray-600 hover:bg-gray-100  ' }}">
                                Approved ({{ $stats['confirmed'] }})
                            </a>
                            <a href="{{ route('manager.events.participants', ['event' => $event, 'status' => 'cancelled']) }}" 
                               class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ request('status') == 'cancelled' ? 'bg-red-100 text-red-700 ' : 'text-gray-600 hover:bg-gray-100  ' }}">
                                Rejected ({{ $stats['cancelled'] }})
                            </a>
                        </div>
                    </div>
                </div>

                @if($participants->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 ">
                            <thead class="bg-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">
                                        Phone
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">
                                        Matric No
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">
                                        Registered On
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500  uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white  divide-y divide-gray-200 ">
                                @foreach($participants as $participant)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 ">
                                                {{ $participant->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 ">
                                                {{ $participant->email }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 ">
                                                {{ $participant->phone_number ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 ">
                                                {{ $participant->matric_no ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($participant->pivot->status == 'confirmed') bg-green-100 text-green-800
                                                @elseif($participant->pivot->status == 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($participant->pivot->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 ">
                                                {{ $participant->pivot->created_at->format('M d, Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500 ">
                                                {{ $participant->pivot->created_at->format('g:i A') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($participant->pivot->status == 'pending')
                                                <div class="flex items-center justify-end gap-2">
                                                    <form action="{{ route('manager.events.participants.update', [$event, $participant]) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded transition-colors" style="background-color: #22c55e; color: white;">
                                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                            Approve
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('manager.events.participants.update', [$event, $participant]) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded transition-colors" style="background-color: #ef4444; color: white;">
                                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <form action="{{ route('manager.events.participants.update', [$event, $participant]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select 
                                                        name="status" 
                                                        onchange="this.form.submit()"
                                                        class="text-xs border-gray-300 bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                    >
                                                        <option value="pending" {{ $participant->pivot->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="confirmed" {{ $participant->pivot->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                        <option value="cancelled" {{ $participant->pivot->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 ">
                        {{ $participants->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 ">No participants yet</h3>
                        <p class="mt-1 text-sm text-gray-500 ">
                            No one has registered for this event yet.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
