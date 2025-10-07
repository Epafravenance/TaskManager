<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🔐 {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden shadow-lg sm:rounded-lg p-6 text-white">
                    <div class="text-sm opacity-90">Total Users</div>
                    <div class="text-4xl font-bold mt-2">{{ $stats['total_users'] }}</div>
                    <div class="text-xs mt-2 opacity-75">
                        {{ $stats['admin_users'] }} admins, {{ $stats['regular_users'] }} users
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-500 to-purple-600 overflow-hidden shadow-lg sm:rounded-lg p-6 text-white">
                    <div class="text-sm opacity-90">Total Teams</div>
                    <div class="text-4xl font-bold mt-2">{{ $stats['total_teams'] }}</div>
                    <a href="{{ route('admin.teams.index') }}" class="text-xs mt-2 block hover:underline">Manage Teams
                        →</a>
                </div>

                <div
                    class="bg-gradient-to-br from-green-500 to-green-600 overflow-hidden shadow-lg sm:rounded-lg p-6 text-white">
                    <div class="text-sm opacity-90">Total Tasks</div>
                    <div class="text-4xl font-bold mt-2">{{ $stats['total_tasks'] }}</div>
                    <a href="{{ route('admin.tasks.index') }}" class="text-xs mt-2 block hover:underline">View All Tasks
                        →</a>
                </div>

                <div
                    class="bg-gradient-to-br from-orange-500 to-orange-600 overflow-hidden shadow-lg sm:rounded-lg p-6 text-white">
                    <div class="text-sm opacity-90">Total Comments</div>
                    <div class="text-4xl font-bold mt-2">{{ $stats['total_comments'] }}</div>
                    <div class="text-xs mt-2 opacity-75">Across all tasks</div>
                </div>
            </div>

            <!-- Task Status Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-yellow-50 border-2 border-yellow-200 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-yellow-700 text-sm font-semibold">Pending Tasks</div>
                    <div class="text-3xl font-bold text-yellow-800 mt-2">{{ $stats['pending_tasks'] }}</div>
                </div>

                <div class="bg-blue-50 border-2 border-blue-200 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-blue-700 text-sm font-semibold">In Progress</div>
                    <div class="text-3xl font-bold text-blue-800 mt-2">{{ $stats['in_progress_tasks'] }}</div>
                </div>

                <div class="bg-green-50 border-2 border-green-200 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-green-700 text-sm font-semibold">Completed Tasks</div>
                    <div class="text-3xl font-bold text-green-800 mt-2">{{ $stats['completed_tasks'] }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Recent Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Users</h3>
                            <a href="{{ route('admin.users.index') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm">View All →</a>
                        </div>

                        <div class="space-y-3">
                            @foreach($recentUsers as $user)
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
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Active Teams -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Most Active Teams</h3>
                            <a href="{{ route('admin.teams.index') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm">View All →</a>
                        </div>

                        <div class="space-y-3">
                            @foreach($activeTeams as $team)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $team->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $team->tasks_count }} tasks</p>
                                    </div>
                                    <a href="{{ route('admin.teams.show', $team) }}"
                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                        View →
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Tasks -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Tasks</h3>
                        <a href="{{ route('admin.tasks.index') }}"
                            class="text-blue-600 hover:text-blue-800 text-sm">View All →</a>
                    </div>

                    <div class="space-y-3">
                        @foreach($recentTasks as $task)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <a href="{{ route('tasks.show', $task) }}"
                                            class="text-blue-600 hover:underline font-medium">
                                            {{ $task->title }}
                                        </a>
                                        <div class="text-sm text-gray-600 mt-1">
                                            Team: {{ $task->team->name }} •
                                            Created by: {{ $task->creator->name }} •
                                            Assigned to: {{ $task->assignee ? $task->assignee->name : 'Unassigned' }}
                                        </div>
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
                </div>
            </div>

        </div>
    </div>
</x-app-layout>