{{-- File: resources/views/components/admin/stat-card.blade.php --}}
@props([
    'title',
    'value',
    'icon',
    'change',
    'trend' => 'neutral',
    'chartData' => '[]',
    'url' => null
])

@php
    $trendClasses = [
        'up' => 'text-green-600 dark:text-green-400',
        'down' => 'text-red-600 dark:text-red-400',
        'neutral' => 'text-gray-500 dark:text-gray-400'
    ][$trend];
@endphp

<{{ $url ? 'a' : 'div' }} 
    @if($url) href="{{ $url }}" @endif
    class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700/50 flex flex-col justify-between {{ $url ? 'hover:bg-gray-50 dark:hover:bg-gray-700/60 transition-colors' : '' }}"
>
    <div class="flex items-start justify-between">
        <div>
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400">{{ $title }}</h3>
            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $value }}</p>
        </div>
        <div class="p-2 bg-indigo-100 dark:bg-indigo-500/10 rounded-lg">
            @if ($icon == 'users')
                <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372..."/>
                </svg>
            @endif
            @if ($icon == 'eye')
                <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="..."/>
                </svg>
            @endif
            @if ($icon == 'collection')
                <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="..."/>
                </svg>
            @endif
            @if ($icon == 'cash')
                <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="..."/>
                </svg>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <div class="h-12">
            <canvas data-chart data-chart-data="{{ json_encode($chartData) }}" data-chart-trend="{{ $trend }}"></canvas>
        </div>
        <div class="flex items-center gap-1 text-xs mt-2 {{ $trendClasses }}">
            @if ($trend === 'up')
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" transform="rotate(45 12 12) translate(-2 2)" />
                </svg>
            @endif
            @if ($trend === 'down')
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" transform="rotate(135 12 12) translate(-2 -2)" />
                </svg>
            @endif
            <span>{{ $change }} vs bulan lalu</span>
        </div>
    </div>
</{{ $url ? 'a' : 'div' }}>
