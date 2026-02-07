@props(['text' => 'or'])

<div class="relative my-6">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-slate-200"></div>
    </div>
    <div class="relative flex justify-center text-sm">
        <span class="px-4 bg-white text-slate-500">{{ $text }}</span>
    </div>
</div>
