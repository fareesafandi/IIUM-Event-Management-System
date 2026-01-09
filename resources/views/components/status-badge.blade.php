@props(['status'])

@php
    $colors = [
        'open' => 'bg-blue-100 text-blue-800',
        'upcoming' => 'bg-blue-100 text-blue-800',
        'ongoing' => 'bg-green-100 text-green-800',
        'completed' => 'bg-gray-100 text-gray-800',
        'closed' => 'bg-gray-100 text-gray-800',
        'full' => 'bg-red-100 text-red-800',
        'cancelled' => 'bg-red-100 text-red-800',
    ];
    
    $color = $colors[$status] ?? 'bg-gray-100 text-gray-800';
    $displayStatus = ucfirst($status);
@endphp

<span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
    {{ $displayStatus }}
</span>
