<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Edit
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- User Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex flex-col items-center">
                        <div
                            class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center text-white text-3xl font-bold mb-4">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <span
                            class="mt-3 px-3 py-1 text-sm rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    <div class="border-t mt-6 pt-6 space-y-3 text-sm">
                        <div>
                            <span class="text-gray-500">Member Since:</span>
                            <p class="font-semibold text-gray-800">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Teams:</span>
                            <p class="font-semibold text-gray-800">{{ $user->teams->count() }} teams</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Assigned Tasks:</span>
                            <p class="font-semibold text-gray-800">{{ $user->assignedTasks->count() }} tasks</p>
                        </div>
                        <div>
                            <span class="text-gray-500">Created Tasks:</span>
                            <p class="font-semibold text-gray-800">{{ $user->createdTasks->count() }} tasks</p>
                        </div>
                    </div>
                </div>

                <!-- Teams & Tasks -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Teams -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Teams ({{ $user->teams->count() }})</h3>

                        @if($user->teams->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($user->teams as $team)
                                    <a href="{{ route('admin.teams.show', $team) }}"
                                        class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 hover:border-blue-300">
                                        <h4 class="font-semibold text-gray-800">{{ $team->name }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ $team->description }}</p>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">Not a member of any team</p>
                        @endif
                    </div>

                    <!-- Assigned Tasks -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Assigned Tasks
                            ({{ $user->assignedTasks->count() }})</h3>

                        @if($user->assignedTasks->count() > 0)
                            <div class="space-y-3">
                                @foreach($user->assignedTasks as $task)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <a href="{{ route('tasks.show', $task) }}"
                                                    class="text-blue-600 hover:underline font-medium">
                                                    {{ $task->title }}
                                                </a>
                                                <p class="text-sm text-gray-600 mt-1">Team: {{ $task->team->name }}</p>
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
                            <p class="text-gray-500 text-center py-4">No tasks assigned</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>