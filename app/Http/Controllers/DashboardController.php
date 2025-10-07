<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's teams
        $teams = $user->teams()->with('tasks')->get();
        
        // Get tasks assigned to user
        $myTasks = Task::where('assigned_to', $user->id)
            ->with(['team', 'creator'])
            ->latest()
            ->take(5)
            ->get();
        
        // Get tasks created by user
        $createdTasks = Task::where('created_by', $user->id)
            ->with(['team', 'assignee'])
            ->latest()
            ->take(5)
            ->get();
        
        // Statistics
        $stats = [
            'total_tasks' => Task::where('assigned_to', $user->id)->count(),
            'pending' => Task::where('assigned_to', $user->id)->where('status', 'pending')->count(),
            'in_progress' => Task::where('assigned_to', $user->id)->where('status', 'in_progress')->count(),
            'completed' => Task::where('assigned_to', $user->id)->where('status', 'completed')->count(),
            'teams_count' => $teams->count(),
        ];
        
        return view('dashboard', compact('myTasks', 'createdTasks', 'teams', 'stats'));
    }
}