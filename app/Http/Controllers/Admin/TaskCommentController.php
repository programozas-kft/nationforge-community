<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate(['body' => 'required|string|max:5000']);

        $task->comments()->create([
            'user_id' => auth()->id(),
            'body'    => $request->body,
        ]);

        return redirect()->route('admin.tasks.show', $task)->with('success', __('tasks.comment_added'));
    }

    public function destroy(Task $task, TaskComment $comment)
    {
        $user = auth()->user();
        $canDelete = $comment->user_id === $user->id
            || $user->hasAnyRole(['super-admin', 'admin']);

        abort_unless($canDelete, 403);

        $comment->delete();

        return redirect()->route('admin.tasks.show', $task)->with('success', __('tasks.comment_deleted'));
    }
}
