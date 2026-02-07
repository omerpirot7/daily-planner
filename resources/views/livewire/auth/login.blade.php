<x-auth.auth-card>
    <!-- Welcome Message -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">
            Welcome back!
        </h2>
        <p class="text-slate-600">
            Sign in to continue your productive journey with ZenPlan
        </p>
    </div>

    <!-- Google Sign In -->
    <x-auth.social-button
        provider="google"
        href="{{ route('auth.google') }}"
    />

    <!-- Divider -->
    <x-auth.divider text="or continue with email" />

    <!-- Login Form -->
    <form wire:submit.prevent="login">
        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-green-800">{{ session('success') }}</p>
            </div>
        @endif

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

        <!-- Password -->
        <x-auth.input
            label="Password"
            type="password"
            id="password"
            name="password"
            wire:model="password"
            :error="$errors->first('password')"
            required
            placeholder="Enter your password"
            autocomplete="current-password"
        />

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" wire:model="remember"
                       class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer">
                <span class="ml-2 text-sm text-slate-600">Remember me</span>
            </label>
            <a href="{{ route('password.request') }}"
               class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                Forgot password?
            </a>
        </div>

        <!-- Submit Button -->
        <button type="submit"
                wire:loading.attr="disabled"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/50 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
            <span wire:loading.remove wire:target="login">Sign In</span>
            <span wire:loading wire:target="login" class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                </svg>
                Signing in...
            </span>
        </button>
    </form>

    <!-- Sign Up Link -->
    <x-slot:footer>
        <p class="text-slate-600">
            Don't have an account?
            <a href="{{ route('register') }}"
               class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">
                Sign up for free
            </a>
        </p>
    </x-slot:footer>
</x-auth.auth-card>
