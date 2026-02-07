<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

#[Layout('components.layouts.app')]
#[Title('Reset Password - ZenPlan')]
class ResetPassword extends Component
{
    public $token;
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|string|min:8|confirmed',
    ];

    protected $messages = [
        'email.required' => 'Email address is required',
        'email.email' => 'Please enter a valid email address',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 8 characters',
        'password.confirmed' => 'Password confirmation does not match',
    ];

    public function resetPassword()
    {
        $this->validate();

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('success', 'Your password has been reset successfully!');
            return redirect()->route('login');
        } else {
            throw ValidationException::withMessages([
                'email' => 'This password reset link is invalid or has expired.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
