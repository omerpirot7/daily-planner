<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
#[Title('Sign Up - Daily Planner')]
class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $terms = false;

    protected $rules = [
        'name' => 'required|string|max:255|min:2',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'terms' => 'accepted',
    ];

    protected $messages = [
        'name.required' => 'Full name is required',
        'name.min' => 'Name must be at least 2 characters',
        'email.required' => 'Email address is required',
        'email.email' => 'Please enter a valid email address',
        'email.unique' => 'This email is already registered',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 8 characters',
        'password.confirmed' => 'Password confirmation does not match',
        'terms.accepted' => 'You must accept the terms and conditions',
    ];

    public function updatedPassword()
    {
        // This will trigger password strength calculation in the frontend
        $this->dispatch('passwordUpdated', $this->password);
    }

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        session()->flash('success', 'Welcome to Daily Planner! Your account has been created successfully.');

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
