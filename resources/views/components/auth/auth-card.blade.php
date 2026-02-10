<div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gradient-to-br from-indigo-50 via-white to-emerald-50">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center mb-4">
                <img src="/images/logo.png" alt="Daily Planner" class="w-16 h-16 drop-shadow-lg">
            </div>
            <h1 class="text-3xl font-extrabold bg-gradient-to-r from-indigo-600 to-emerald-500 bg-clip-text text-transparent">
                Daily Planner
            </h1>
            <p class="text-slate-400 text-sm font-medium mt-1 tracking-wide">Plan your day, own your life</p>
        </div>

        <!-- Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-indigo-100/50 border border-white/60 p-8 sm:p-12">
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
