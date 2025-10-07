<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Tasks') }}
            </h2>
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + Create Task
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($tasks->count() > 0)
                        <div class="space-y-4">
                            @foreach($tasks as $task)
                                <div class="border border-gray-200 rounded-lg p-5 hover:bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <a href="{{ route('tasks.show', $task) }}"
                                                class="text-lg font-semibold text-blue-600 hover:underline">
                                                {{ $task->title }}
                                            </a>
                                            <p class="text-gray-600 mt-2">{{ Str::limit($task->description, 100) }}</p>
                                            <div class="flex gap-4 text-sm text-gray-500 mt-3">
                                                <span>Team: <strong>{{ $task->team->name }}</strong></span>
                                                <span>Created by: <strong>{{ $task->creator->name }}</strong></span>
                                                @if($task->assignee)
                                                    <span>Assigned to: <strong>{{ $task->assignee->name }}</strong></span>
                                                @endif
                                                @if($task->due_date)
                                                    <span>Due: <strong>{{ $task->due_date->format('M d, Y') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex flex-col gap-2 ml-4">
                                            <span class="px-3 py-1 text-xs rounded-full text-center
                                                        @if($task->priority === 'high') bg-red-100 text-red-700
                                                        @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-700
                                                        @else bg-green-100 text-green-700
                                                        @endif">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            <span class="px-3 py-1 text-xs rounded-full text-center
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

                        <div class="mt-6">
                            {{ $tasks->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No tasks found in your teams.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>