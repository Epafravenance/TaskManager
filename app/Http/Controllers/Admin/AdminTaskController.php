<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class AdminTaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['team', 'creator', 'assignee']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority !== '') {
            $query->where('priority', $request->priority);
        }

        // Filter by team
        if ($request->has('team') && $request->team !== '') {
            $query->where('team_id', $request->team);
        }

        $tasks = $query->latest()->paginate(15);
        $teams = \App\Models\Team::all();

        return view('admin.tasks.index', compact('tasks', 'teams'));
    }
}