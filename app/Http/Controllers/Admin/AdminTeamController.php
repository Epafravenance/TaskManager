<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTeamController extends Controller
{
    public function index()
    {
        $teams = Team::withCount(['users', 'tasks'])
            ->with('creator')
            ->latest()
            ->paginate(15);

        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['created_by'] = optional(\Auth::user())->id;

        Team::create($validated);

        return redirect()->route('admin.teams.index')->with('success', 'Team created successfully!');
    }

    public function show(Team $team)
    {
        $team->load(['users', 'tasks.assignee', 'creator']);
        $availableUsers = User::whereDoesntHave('teams', function ($query) use ($team) {
            $query->where('team_id', $team->id);
        })->get();

        return view('admin.teams.show', compact('team', 'availableUsers'));
    }

    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $team->update($validated);

        return redirect()->route('admin.teams.index')->with('success', 'Team updated successfully!');
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('admin.teams.index')->with('success', 'Team deleted successfully!');
    }

    public function addMember(Request $request, Team $team)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $team->users()->attach($validated['user_id']);

        return redirect()->route('admin.teams.show', $team)->with('success', 'Member added successfully!');
    }

    public function removeMember(Team $team, User $user)
    {
        $team->users()->detach($user->id);

        return redirect()->route('admin.teams.show', $team)->with('success', 'Member removed successfully!');
    }
}