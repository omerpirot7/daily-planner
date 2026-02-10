<div class="max-w-4xl mx-auto p-6 space-y-8 font-sans text-gray-800">
    
    <!-- Header Section -->
    <div class="flex justify-between items-end">
        <div class="flex items-center gap-4">
            <img src="/images/logo.png" alt="Daily Planner" class="w-16 h-16 drop-shadow-md">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">
                    Good Morning &nbsp; <span class="text-indigo-500">&#10024;</span>
                </h1>
                <p class="mt-1 text-lg text-gray-500 font-medium">{{ \Carbon\Carbon::now()->toFormattedDateString() }}</p>
            </div>
        </div>
        
        <!-- Stats Widget -->
        <div class="bg-white px-6 py-4 rounded-2xl shadow-lg shadow-indigo-100 border border-gray-100 w-64">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-semibold text-gray-600">Daily Progress</span>
                <span class="text-sm font-bold text-indigo-600">{{ $this->completionStats['completed'] }}/{{ $this->completionStats['total'] }}</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                <div class="bg-indigo-500 h-2.5 rounded-full transition-all duration-1000 ease-out" 
                     style="width: {{ $this->completionStats['percentage'] }}%"></div>
            </div>
        </div>
    </div>

    <!-- Input Area -->
    <div class="bg-white rounded-2xl shadow-xl shadow-indigo-500/10 p-2 border border-blue-50/50">
        <form wire:submit.prevent="add" class="flex items-center gap-4 p-2">
            <div class="flex-grow">
                <input 
                    wire:model="title" 
                    type="text" 
                    placeholder="What's your main focus today?" 
                    class="w-full border-0 bg-transparent text-lg placeholder-gray-400 focus:ring-0 text-gray-700 font-medium"
                >
            </div>
            
            <select wire:model="priority" class="border-none bg-gray-50 text-gray-600 text-sm rounded-xl px-4 py-2 focus:ring-0 cursor-pointer hover:bg-gray-100 transition-colors">
                <option value="low">Low Priority</option>
                <option value="medium">Medium</option>
                <option value="high">High Priority</option>
            </select>
            
            <select wire:model="category" class="border-none bg-gray-50 text-gray-600 text-sm rounded-xl px-4 py-2 focus:ring-0 cursor-pointer hover:bg-gray-100 transition-colors">
                <option value="Personal">Personal</option>
                <option value="Work">Work</option>
                <option value="Learning">Learning</option>
            </select>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl p-3 shadow-lg shadow-indigo-200 transition-all hover:scale-105 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </button>
        </form>
    </div>
    @error('title') <span class="text-red-500 text-sm pl-4">{{ $message }}</span> @enderror

    <!-- Task List -->
    <div class="space-y-3">
        @php $currentDate = null; @endphp
        @foreach($this->tasks as $task)
            @php
                $taskDate = $task->created_at->format('Y-m-d');
                $isNewDate = $currentDate !== $taskDate;
                $currentDate = $taskDate;
            @endphp

            @if($isNewDate)
                <!-- Date Header -->
                <div class="flex items-center gap-4 pt-6 pb-2 {{ !$loop->first ? 'mt-4 border-t border-gray-100' : '' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center
                            {{ $task->created_at->isToday() ? 'bg-indigo-100 text-indigo-600' : ($task->created_at->isYesterday() ? 'bg-amber-100 text-amber-600' : 'bg-gray-100 text-gray-500') }}">
                            <span class="text-sm font-bold">{{ $task->created_at->format('d') }}</span>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold uppercase tracking-wider
                                {{ $task->created_at->isToday() ? 'text-indigo-600' : ($task->created_at->isYesterday() ? 'text-amber-600' : 'text-gray-400') }}">
                                @if($task->created_at->isToday())
                                    Today
                                @elseif($task->created_at->isYesterday())
                                    Yesterday
                                @else
                                    {{ $task->created_at->format('l') }}
                                @endif
                            </h2>
                            <p class="text-xs text-gray-400">{{ $task->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex-1 h-px bg-gradient-to-r from-gray-200 to-transparent"></div>
                </div>
            @endif

            <div 
                wire:key="task-{{ $task->id }}"
                x-data="{ done: {{ $task->status === 'completed' ? 'true' : 'false' }} }"
                class="group flex items-center justify-between p-5 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300"
                :class="done ? 'opacity-60 bg-gray-50' : ''"
            >
                <div class="flex items-center gap-5">
                    <!-- Custom Checkbox (optimistic toggle) -->
                    <button 
                        @click="done = !done; $wire.toggle({{ $task->id }})"
                        class="relative w-8 h-8 rounded-full border-2 flex items-center justify-center transition-all duration-300"
                        :class="done ? 'bg-indigo-500 border-indigo-500' : 'border-gray-200 hover:border-indigo-400'"
                    >
                        <svg x-show="done" x-transition.scale.origin.center xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </button>

                    <div>
                        <h3 class="text-lg font-semibold transition-all"
                            :class="done ? 'line-through text-gray-400' : 'text-gray-800'">
                            {{ $task->title }}
                        </h3>
                        
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-xs font-bold px-2.5 py-1 rounded-lg 
                                @if($task->priority === 'high') bg-red-50 text-red-600
                                @elseif($task->priority === 'medium') bg-amber-50 text-amber-600
                                @else bg-green-50 text-green-600 @endif">
                                {{ ucfirst($task->priority) }}
                            </span>
                            
                            <span class="text-xs text-gray-400 font-medium tracking-wide uppercase">{{ $task->category }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button wire:click="delete({{ $task->id }})" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Delete Task">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    </button>
                </div>
            </div>
        @endforeach
        
        @if($this->tasks->isEmpty())
             <div class="text-center py-12">
                <div class="bg-indigo-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <h3 class="text-gray-900 font-medium text-lg">All caught up!</h3>
                <p class="text-gray-500">Start your day by adding a new task above.</p>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $this->tasks->links() }}
    </div>

</div>
