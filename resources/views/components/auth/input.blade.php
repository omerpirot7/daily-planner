@props(['label', 'type' => 'text', 'id', 'name', 'error' => null, 'required' => false])

<div class="mb-4">
    <label for="{{ $id }}" class="block text-sm font-medium text-slate-700 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <input
        type="{{ $type }}"
        id="{{ $id }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all duration-200 ' . ($error ? 'border-red-500 bg-red-50' : 'border-slate-300 hover:border-slate-400')]) }}
    >

    @if($error)
        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span>{{ $error }}</span>
        </p>
    @endif
</div>
