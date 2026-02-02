<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DailyPlanner extends Component
{
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

        // In a real app, use Auth::id(). For demo purposes if no user logged in, we might need a fallback or ensure auth middleware.
        // Assuming strictly guarded route or creating a dummy user for demo if needed.
        $userId = Auth::id() ?? 1; // Fallback for pure demo/seed environments

        Task::create([
            'user_id' => $userId,
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
        $task = Task::find($taskId);
        
        if ($task) { // Add authorization check here in prod: && $task->user_id === Auth::id()
            $task->status = $task->status === 'completed' ? 'pending' : 'completed';
            $task->save();
        }
    }

    public function delete($taskId)
    {
        $task = Task::find($taskId);
        
        if ($task) {
           $task->delete();
        }
    }

    #[Computed]
    public function tasks()
    {
         // Fetch tasks, with completed ones at the bottom, then by priority/date
         return Task::query() // Add ->where('user_id', Auth::id())
            ->orderByRaw("status = 'completed'") // false (0) comes before true (1), so pending first
            ->orderByDesc('created_at')
            ->get();
    }

    #[Computed]
    public function completionStats()
    {
        $tasks = $this->tasks;
        $total = $tasks->count();
        
        if ($total === 0) return ['completed' => 0, 'total' => 0, 'percentage' => 0];

        $completed = $tasks->where('status', 'completed')->count();
        $percentage = round(($completed / $total) * 100);

        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $percentage
        ];
    }

    public function render()
    {
        return view('livewire.daily-planner');
    }
}
