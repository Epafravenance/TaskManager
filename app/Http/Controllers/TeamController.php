<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teams = $user->teams()->withCount(['users', 'tasks'])->get();
        
        return view('teams.index', compact('teams'));
    }

    public function show(Team $team)
    {
        $user = Auth::user();
        
        // Check if user is member of this team
        if (!$user->teams->contains($team->id) && !$user->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        
        $team->load(['users', 'tasks.assignee', 'creator']);
        
        return view('teams.show', compact('team'));
    }
}