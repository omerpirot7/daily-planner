<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Carbon\Carbon;

#[Layout('components.layouts.app')]
#[Title('Dashboard - Daily Planner')]
class Dashboard extends Component
{
    #[Computed]
    public function todayTasksCount()
    {
        return Task::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->count();
    }

    #[Computed]
    public function completedCount()
    {
        return Task::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->count();
    }

    #[Computed]
    public function productivity()
    {
        $total = Task::where('user_id', Auth::id())->count();
        if ($total === 0) return 0;
        $completed = $this->completedCount;
        return round(($completed / $total) * 100);
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
