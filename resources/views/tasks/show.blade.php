<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Task Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('tasks.edit', $task) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Edit
                </a>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                    onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $task->title }}</h1>

                        <div class="flex gap-2 mb-6">
                            <span class="px-3 py-1 text-sm rounded-full
                                @if($task->priority === 'high') bg-red-100 text-red-700
                                @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-700
                                @else bg-green-100 text-green-700
                                @endif">
                                {{ ucfirst($task->priority) }} Priority
                            </span>
                            <span class="px-3 py-1 text-sm rounded-full
                                @if($task->status === 'completed') bg-green-100 text-green-700
                                @elseif($task->status === 'in_progress') bg-blue-100 text-blue-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ str_replace('_', ' ', ucfirst($task->status)) }}
                            </span>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-700 mb-2">Description</h3>
                            <p class="text-gray-600">{{ $task->description ?? 'No description provided.' }}</p>
                        </div>

                        <!-- Comments Section -->
                        <div class="border-t pt-6">
                            <h3 class="font-semibold text-gray-700 mb-4">Comments ({{ $task->comments->count() }})</h3>

                            <!-- Comment Form -->
                            <form method="POST" action="{{ route('tasks.comments.store', $task) }}" class="mb-6">
                                @csrf
                                <textarea name="content" rows="3" placeholder="Add a comment..." required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                <button type="submit"
                                    class="mt-2 bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                                    Post Comment
                                </button>
                            </form>

                            <!-- Comments List -->
                            <div class="space-y-4">
                                @forelse($task->comments as $comment)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                                            <span
                                                class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-600">{{ $comment->content }}</p>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-center py-4">No comments yet. Be the first to comment!</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Task Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-semibold text-gray-700 mb-4">Task Information</h3>

                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-gray-500">Team:</span>
                                <a href="{{ route('teams.show', $task->team) }}"
                                    class="block font-semibold text-blue-600 hover:underline">
                                    {{ $task->team->name }}
                                </a>
                            </div>

                            <div>
                                <span class="text-gray-500">Created by:</span>
                                <p class="font-semibold text-gray-800">{{ $task->creator->name }}</p>
                            </div>

                            <div>
                                <span class="text-gray-500">Assigned to:</span>
                                <p class="font-semibold text-gray-800">
                                    {{ $task->assignee ? $task->assignee->name : 'Unassigned' }}
                                </p>
                            </div>

                            @if($task->due_date)
                                <div>
                                    <span class="text-gray-500">Due Date:</span>
                                    <p class="font-semibold text-gray-800">{{ $task->due_date->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $task->due_date->diffForHumans() }}</p>
                                </div>
                            @endif

                            <div>
                                <span class="text-gray-500">Created:</span>
                                <p class="text-gray-600">{{ $task->created_at->format('M d, Y h:i A') }}</p>
                            </div>

                            <div>
                                <span class="text-gray-500">Last Updated:</span>
                                <p class="text-gray-600">{{ $task->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>