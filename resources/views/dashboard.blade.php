<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 text-sm">Total Tasks</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $stats['total_tasks'] }}</div>
                </div>

                <div class="bg-yellow-50 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-yellow-600 text-sm">Pending</div>
                    <div class="text-3xl font-bold text-yellow-700">{{ $stats['pending'] }}</div>
                </div>

                <div class="bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-blue-600 text-sm">In Progress</div>
                    <div class="text-3xl font-bold text-blue-700">{{ $stats['in_progress'] }}</div>
                </div>

                <div class="bg-green-50 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-green-600 text-sm">Completed</div>
                    <div class="text-3xl font-bold text-green-700">{{ $stats['completed'] }}</div>
                </div>

                <div class="bg-purple-50 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-purple-600 text-sm">Teams</div>
                    <div class="text-3xl font-bold text-purple-700">{{ $stats['teams_count'] }}</div>
                </div>
            </div>

            <!-- My Tasks -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Tasks Assigned to Me</h3>
                        <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View
                            All</a>
                    </div>

                    @if($myTasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($myTasks as $task)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <a href="{{ route('tasks.show', $task) }}"
                                                class="text-blue-600 hover:underline font-medium">
                                                {{ $task->title }}
                                            </a>
                                            <div class="text-sm text-gray-600 mt-1">
                                                Team: {{ $task->team->name }} • Created by: {{ $task->creator->name }}
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                        @if($task->priority === 'high') bg-red-100 text-red-700
                                                        @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-700
                                                        @else bg-green-100 text-green-700
                                                        @endif">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            <span class="px-2 py-1 text-xs rounded-full
                                                        @if($task->status === 'completed') bg-green-100 text-green-700
                                                        @elseif($task->status === 'in_progress') bg-blue-100 text-blue-700
                                                        @else bg-gray-100 text-gray-700
                                                        @endif">
                                                {{ str_replace('_', ' ', ucfirst($task->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No tasks assigned to you yet.</p>
                    @endif
                </div>
            </div>

            <!-- Tasks I Created -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Tasks I Created</h3>
                        <a href="{{ route('tasks.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                            + New Task
                        </a>
                    </div>

                    @if($createdTasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($createdTasks as $task)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <a href="{{ route('tasks.show', $task) }}"
                                                class="text-blue-600 hover:underline font-medium">
                                                {{ $task->title }}
                                            </a>
                                            <div class="text-sm text-gray-600 mt-1">
                                                Team: {{ $task->team->name }}
                                                @if($task->assignee)
                                                    • Assigned to: {{ $task->assignee->name }}
                                                @else
                                                    • Not assigned
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                        @if($task->priority === 'high') bg-red-100 text-red-700
                                                        @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-700
                                                        @else bg-green-100 text-green-700
                                                        @endif">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            <span class="px-2 py-1 text-xs rounded-full
                                                        @if($task->status === 'completed') bg-green-100 text-green-700
                                                        @elseif($task->status === 'in_progress') bg-blue-100 text-blue-700
                                                        @else bg-gray-100 text-gray-700
                                                        @endif">
                                                {{ str_replace('_', ' ', ucfirst($task->status)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">You haven't created any tasks yet.</p>
                    @endif
                </div>
            </div>

            <!-- My Teams -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">My Teams</h3>
                        <a href="{{ route('teams.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View
                            All</a>
                    </div>

                    @if($teams->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($teams as $team)
                                <a href="{{ route('teams.show', $team) }}"
                                    class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 hover:border-blue-300 transition">
                                    <h4 class="font-semibold text-gray-800">{{ $team->name }}</h4>
                                    <p class="text-sm text-gray-600 mt-2">{{ $team->tasks->count() }} tasks</p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">You're not a member of any team yet.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>