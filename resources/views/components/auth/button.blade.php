@props(['type' => 'button', 'variant' => 'primary', 'loading' => false])

@php
    $baseClasses = 'w-full py-3 rounded-lg font-semibold focus:ring-4 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2';

    $variantClasses = match($variant) {
        'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500/50',
        'secondary' => 'bg-slate-200 text-slate-800 hover:bg-slate-300 focus:ring-slate-500/50',
        'outline' => 'border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-50 focus:ring-indigo-500/50',
        default => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500/50',
    };
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses]) }}
>
    @if($loading)
        <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
        </svg>
    @endif
    {{ $slot }}
</button>
