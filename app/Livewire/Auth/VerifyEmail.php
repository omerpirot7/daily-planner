<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
#[Title('Verify Email - ZenPlan')]
class VerifyEmail extends Component
{
    public $emailSent = false;

    public function mount()
    {
        // If already verified, redirect to dashboard
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
    }

    public function resendVerificationEmail()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        Auth::user()->sendEmailVerificationNotification();

        $this->emailSent = true;
        session()->flash('success', 'A new verification link has been sent to your email address.');
    }

    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
