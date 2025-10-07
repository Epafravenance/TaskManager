<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $team->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.teams.edit', $team) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Edit
                </a>
                <a href="{{ route('admin.teams.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                    Back
                </a>
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

            <!-- Team Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">About This Team</h3>
                    <p class="text-gray-600">{{ $team->description ?? 'No description provided.' }}</p>
                    <p class="text-sm text-gray-500 mt-2">Created by {{ $team->creator->name }} on
                        {{ $team->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Team Members -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Team Members ({{ $team->users->count() }})
                        </h3>

                        <!-- Add Member Form -->
                        <form method="POST" action="{{ route('admin.teams.add-member', $team) }}" class="mb-6">
                            @csrf
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Add Member</label>
                            <div class="flex gap-2">
                                <select name="user_id" id="user_id" required
                                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    <option value="">Select a user</option>
                                    @foreach($availableUsers as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                                    Add
                                </button>
                            </div>
                        </form>

                        <!-- Members List -->
                        <div class="space-y-3">
                            @foreach($team->users as $user)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('admin.teams.remove-member', [$team, $user]) }}"
                                        onsubmit="return confirm('Remove this member?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 text-sm">Remove</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Team Tasks -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Team Tasks ({{ $team->tasks->count() }})
                                </h3>
                            </div>

                            @if($team->tasks->count() > 0)
                                <div class="space-y-4">
                                    @foreach($team->tasks as $task)
                                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <a href="{{ route('tasks.show', $task) }}"
                                                        class="text-blue-600 hover:underline font-medium">
                                                        {{ $task->title }}
                                                    </a>
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        Created by: {{ $task->creator->name }} •
                                                        Assigned to:
                                                        {{ $task->assignee ? $task->assignee->name : 'Unassigned' }}
                                                    </p>
                                                    @if($task->due_date)
                                                        <p class="text-xs text-gray-500 mt-1">Due:
                                                            {{ $task->due_date->format('M d, Y') }}</p>
                                                    @endif
                                                </div>
                                                <div class="flex gap-2">
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
                                <p class="text-gray-500 text-center py-8">No tasks yet for this team.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>