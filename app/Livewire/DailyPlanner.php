<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DailyPlanner extends Component
{
    use WithPagination;
    #[Rule('required|min:3|max:255')]
    public $title = '';

    #[Rule('nullable|string')]
    public $description = '';

    #[Rule('required|in:low,medium,high')]
    public $priority = 'medium';

    #[Rule('required|string|max:50')]
    public $category = 'Personal';

    public function add()
    {
        $this->validate();

        Task::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'category' => $this->category,
            'status' => 'pending',
            'due_date' => Carbon::now()->endOfDay(),
        ]);

        $this->reset(['title', 'description']);
        
        // Flash message or dispatch event usually goes here
        session()->flash('success', 'Task added successfully.');
    }

    public function toggle($taskId)
    {
        $task = Task::where('id', $taskId)
            ->where('user_id', Auth::id())
            ->first();

        if ($task) {
            $task->status = $task->status === 'completed' ? 'pending' : 'completed';
            $task->save();
        }
    }

    public function delete($taskId)
    {
        Task::where('id', $taskId)
            ->where('user_id', Auth::id())
            ->delete();
    }

    #[Computed]
    public function tasks()
    {
        return Task::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(50);
    }

    #[Computed]
    public function completionStats()
    {
        $total = Task::where('user_id', Auth::id())->count();

        if ($total === 0) return ['completed' => 0, 'total' => 0, 'percentage' => 0];

        $completed = Task::where('user_id', Auth::id())->where('status', 'completed')->count();
        $percentage = round(($completed / $total) * 100);

        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $percentage,
        ];
    }

    public function render()
    {
        return view('livewire.daily-planner')->layout('layouts.app');
    }
}
