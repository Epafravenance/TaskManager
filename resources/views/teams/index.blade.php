<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Teams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($teams->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($teams as $team)
                                <a href="{{ route('teams.show', $team) }}"
                                    class="border border-gray-200 rounded-lg p-6 hover:bg-gray-50 hover:border-blue-300 transition">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $team->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-4">{{ $team->description }}</p>

                                    <div class="flex justify-between text-sm text-gray-500">
                                        <span>👥 {{ $team->users_count }} members</span>
                                        <span>📋 {{ $team->tasks_count }} tasks</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">You're not a member of any team yet.</p>
                            <p class="text-sm text-gray-400">Contact an admin to be added to a team.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>