<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get tasks from user's teams
        $teamIds = $user->teams->pluck('id');
        
        $tasks = Task::whereIn('team_id', $teamIds)
            ->with(['team', 'creator', 'assignee'])
            ->latest()
            ->paginate(10);
        
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $user = Auth::user();
        $teams = $user->teams;
        
        return view('tasks.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'team_id' => 'required|exists:teams,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        
        $validated['created_by'] = Auth::id();
        
        Task::create($validated);
        
        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        $task->load(['team', 'creator', 'assignee', 'comments.user']);
        
        // Check if user has access to this task
        $user = Auth::user();
        if (!$user->teams->contains($task->team_id)) {
            abort(403, 'Unauthorized access to this task');
        }
        
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $user = Auth::user();
        
        // Check authorization
        if (!$user->teams->contains($task->team_id)) {
            abort(403, 'Unauthorized access');
        }
        
        $teams = $user->teams;
        $teamMembers = $task->team->users;
        
        return view('tasks.edit', compact('task', 'teams', 'teamMembers'));
    }

    public function update(Request $request, Task $task)
    {
        $user = Auth::user();
        
        // Check authorization
        if (!$user->teams->contains($task->team_id)) {
            abort(403, 'Unauthorized access');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'team_id' => 'required|exists:teams,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        
        $task->update($validated);
        
        return redirect()->route('tasks.show', $task)->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $user = Auth::user();
        
        // Only creator or admin can delete
        if ($task->created_by !== $user->id && !$user->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        
        $task->delete();
        
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}