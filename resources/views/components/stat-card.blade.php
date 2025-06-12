@props([
    'color' => 'blue',
    'icon' => 'fa-book',
    'title' => 'Statistik',
    'value' => '0',
    'iconColor' => null
])

@php
    $iconColor = $iconColor ?? $color;
    $colorClasses = [
        'blue' => [
            'border' => 'border-blue-500',
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-600'
        ],
        'green' => [
            'border' => 'border-green-500',
            'bg' => 'bg-green-100',
            'text' => 'text-green-600'
        ],
        'yellow' => [
            'border' => 'border-yellow-500',
            'bg' => 'bg-yellow-100',
            'text' => 'text-yellow-600'
        ]
    ];
@endphp

<div class="bg-white rounded-xl shadow-lg p-6 border-l-4 {{ $colorClasses[$color]['border'] }}">
    <div class="flex items-center">
        <div class="{{ $colorClasses[$color]['bg'] }} p-3 rounded-lg mr-4">
            <i class="fas {{ $icon }} {{ $colorClasses[$iconColor]['text'] }} text-xl"></i>
        </div>
        <div>
            <p class="text-gray-600">{{ $title }}</p>
            <p class="text-3xl font-bold">{{ $value }}</p>
        </div>
    </div>
</div>