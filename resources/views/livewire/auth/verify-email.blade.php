<x-auth.auth-card>
    <div class="text-center">
        <!-- Email Icon -->
        <div class="mx-auto w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-slate-800 mb-2">
            Verify your email address
        </h2>
        <p class="text-slate-600 mb-6">
            We've sent a verification link to<br>
            <span class="font-semibold text-slate-800">{{ Auth::user()->email }}</span>
        </p>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-left">
            <h3 class="font-semibold text-blue-900 mb-2 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                What's next?
            </h3>
            <ul class="text-sm text-blue-800 space-y-2">
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 font-bold">1.</span>
                    Check your email inbox (and spam folder)
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 font-bold">2.</span>
                    Click the verification link in the email
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 font-bold">3.</span>
                    Start organizing your tasks with ZenPlan!
                </li>
            </ul>
        </div>

        <!-- Resend Button -->
        <button wire:click="resendVerificationEmail"
                wire:loading.attr="disabled"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/50 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 mb-4">
            <span wire:loading.remove wire:target="resendVerificationEmail">Resend Verification Email</span>
            <span wire:loading wire:target="resendVerificationEmail" class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                </svg>
                Sending...
            </span>
        </button>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-slate-600 hover:text-slate-800 font-medium transition-colors">
                Sign out
            </button>
        </form>
    </div>
</x-auth.auth-card>
