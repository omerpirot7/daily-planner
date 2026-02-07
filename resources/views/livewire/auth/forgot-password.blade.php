<x-auth.auth-card>
    @if($emailSent)
        <!-- Success State -->
        <div class="text-center">
            <!-- Success Icon -->
            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-slate-800 mb-2">
                Check your email
            </h2>
            <p class="text-slate-600 mb-6">
                We've sent a password reset link to<br>
                <span class="font-semibold text-slate-800">{{ $email }}</span>
            </p>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-left">
                <p class="text-sm text-blue-800">
                    <strong>Didn't receive the email?</strong> Check your spam folder or
                    <button wire:click="sendResetLink" class="text-indigo-600 hover:text-indigo-500 font-semibold underline">
                        resend the link
                    </button>
                </p>
            </div>

            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-500 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to login
            </a>
        </div>
    @else
        <!-- Request Form -->
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-slate-800 mb-2">
                Forgot your password?
            </h2>
            <p class="text-slate-600">
                No worries! Enter your email and we'll send you reset instructions
            </p>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="sendResetLink">
            <!-- Email -->
            <x-auth.input
                label="Email Address"
                type="email"
                id="email"
                name="email"
                wire:model="email"
                :error="$errors->first('email')"
                required
                placeholder="you@example.com"
                autocomplete="email"
            />

            <!-- Submit Button -->
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/50 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 mb-4">
                <span wire:loading.remove wire:target="sendResetLink">Send Reset Link</span>
                <span wire:loading wire:target="sendResetLink" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                    </svg>
                    Sending...
                </span>
            </button>

            <a href="{{ route('login') }}"
               class="flex items-center justify-center gap-2 text-slate-600 hover:text-slate-800 font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to login
            </a>
        </form>
    @endif
</x-auth.auth-card>
