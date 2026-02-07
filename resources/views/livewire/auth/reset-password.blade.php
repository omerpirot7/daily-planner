<x-auth.auth-card>
    <!-- Welcome Message -->
    <div class="text-center mb-8">
        <div class="mx-auto w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-slate-800 mb-2">
            Reset your password
        </h2>
        <p class="text-slate-600">
            Enter your new password below
        </p>
    </div>

    <!-- Reset Form -->
    <form wire:submit.prevent="resetPassword">
        <!-- Email (read-only) -->
        <x-auth.input
            label="Email Address"
            type="email"
            id="email"
            name="email"
            wire:model="email"
            :error="$errors->first('email')"
            required
            readonly
        />

        <!-- New Password -->
        <div class="mb-4">
            <x-auth.input
                label="New Password"
                type="password"
                id="password"
                name="password"
                wire:model.live="password"
                :error="$errors->first('password')"
                required
                placeholder="Enter your new password"
                autocomplete="new-password"
            />

            <!-- Password Strength Indicator -->
            @if($password)
                <div class="mt-2" x-data="{
                    strength: 0,
                    label: 'Weak',
                    color: 'bg-red-500'
                }" x-init="
                    $watch('$wire.password', (value) => {
                        if (!value) {
                            strength = 0;
                            return;
                        }

                        let score = 0;
                        if (value.length >= 8) score++;
                        if (value.length >= 12) score++;
                        if (/[a-z]/.test(value) && /[A-Z]/.test(value)) score++;
                        if (/[0-9]/.test(value)) score++;
                        if (/[^a-zA-Z0-9]/.test(value)) score++;

                        strength = Math.min(score, 5);

                        if (strength <= 2) {
                            label = 'Weak';
                            color = 'bg-red-500';
                        } else if (strength <= 3) {
                            label = 'Fair';
                            color = 'bg-yellow-500';
                        } else if (strength <= 4) {
                            label = 'Good';
                            color = 'bg-blue-500';
                        } else {
                            label = 'Strong';
                            color = 'bg-green-500';
                        }
                    });
                ">
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-slate-600">Password strength:</span>
                        <span class="font-semibold" :class="{
                            'text-red-600': strength <= 2,
                            'text-yellow-600': strength === 3,
                            'text-blue-600': strength === 4,
                            'text-green-600': strength === 5
                        }" x-text="label"></span>
                    </div>
                    <div class="flex gap-1">
                        <template x-for="i in 5" :key="i">
                            <div class="h-1.5 flex-1 rounded-full transition-all duration-300"
                                 :class="i <= strength ? color : 'bg-slate-200'"></div>
                        </template>
                    </div>
                </div>
            @endif
        </div>

        <!-- Confirm Password -->
        <x-auth.input
            label="Confirm New Password"
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            wire:model="password_confirmation"
            :error="$errors->first('password_confirmation')"
            required
            placeholder="Re-enter your new password"
            autocomplete="new-password"
        />

        <!-- Submit Button -->
        <button type="submit"
                wire:loading.attr="disabled"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/50 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 mb-4">
            <span wire:loading.remove wire:target="resetPassword">Reset Password</span>
            <span wire:loading wire:target="resetPassword" class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                </svg>
                Resetting...
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
</x-auth.auth-card>
