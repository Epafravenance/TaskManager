<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Team;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // System Statistics
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'regular_users' => User::where('role', 'user')->count(),
            'total_teams' => Team::count(),
            'total_tasks' => Task::count(),
            'pending_tasks' => Task::where('status', 'pending')->count(),
            'in_progress_tasks' => Task::where('status', 'in_progress')->count(),
            'completed_tasks' => Task::where('status', 'completed')->count(),
            'total_comments' => Comment::count(),
        ];

        // Recent Users
        $recentUsers = User::latest()->take(5)->get();

        // Recent Tasks
        $recentTasks = Task::with(['team', 'creator', 'assignee'])
            ->latest()
            ->take(5)
            ->get();

        // Teams with most tasks
        $activeTeams = Team::withCount('tasks')
            ->orderBy('tasks_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentTasks', 'activeTeams'));
    }
}