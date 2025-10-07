<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $task->comments()->create([
            'user_id' => \Auth::user()->id,
            'content' => $validated['content'],
        ]);

        return redirect()->route('tasks.show', $task)->with('success', 'Comment added successfully!');
    }
}