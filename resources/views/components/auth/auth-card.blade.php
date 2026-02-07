<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-indigo-600 mb-2">ZenPlan</h1>
            <div class="w-16 h-1 bg-indigo-600 mx-auto rounded-full"></div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-8 sm:p-12">
            {{ $slot }}
        </div>

        <!-- Footer Links -->
        @isset($footer)
            <div class="mt-6 text-center">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>
