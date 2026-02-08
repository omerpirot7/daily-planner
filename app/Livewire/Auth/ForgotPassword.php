<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

#[Layout('components.layouts.app')]
#[Title('Forgot Password - Daily Planner')]
class ForgotPassword extends Component
{
    public $email = '';
    public $emailSent = false;

    protected $rules = [
        'email' => 'required|email',
    ];

    protected $messages = [
        'email.required' => 'Email address is required',
        'email.email' => 'Please enter a valid email address',
    ];

    public function sendResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(
            ['email' => $this->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->emailSent = true;
            session()->flash('success', 'We have emailed your password reset link!');
        } else {
            throw ValidationException::withMessages([
                'email' => 'We could not find a user with that email address.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
