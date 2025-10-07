<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Team;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Task routes
    Route::resource('tasks', TaskController::class);
    
     // Comment route
    Route::post('/tasks/{task}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('tasks.comments.store');
    
    // Team routes
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// API route for getting team members
Route::middleware('auth')->get('/api/teams/{team}/members', function (Team $team) {
    return $team->users;
});

require __DIR__.'/auth.php';

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', App\Http\Controllers\Admin\AdminUserController::class);
    
    // Team Management
    Route::resource('teams', App\Http\Controllers\Admin\AdminTeamController::class);
    Route::post('teams/{team}/add-member', [App\Http\Controllers\Admin\AdminTeamController::class, 'addMember'])->name('teams.add-member');
    Route::delete('teams/{team}/remove-member/{user}', [App\Http\Controllers\Admin\AdminTeamController::class, 'removeMember'])->name('teams.remove-member');
    
    // Tasks Overview
    Route::get('/tasks', [App\Http\Controllers\Admin\AdminTaskController::class, 'index'])->name('tasks.index');
});