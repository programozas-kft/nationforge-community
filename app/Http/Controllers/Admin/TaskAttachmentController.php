<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskAttachmentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,webp,zip,rar,txt,csv',
        ]);

        $file     = $request->file('file');
        $original = $file->getClientOriginalName();
        $safeName = Str::slug(pathinfo($original, PATHINFO_FILENAME)) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('task-attachments/' . $task->id, $safeName, 'private');

        $task->attachments()->create([
            'user_id'   => auth()->id(),
            'filename'  => $original,
            'path'      => $path,
            'size'      => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);

        return redirect()->route('admin.tasks.show', $task)->with('success', __('tasks.attach_uploaded'));
    }

    public function download(Task $task, TaskAttachment $attachment)
    {
        abort_unless($attachment->task_id === $task->id, 404);
        abort_unless(Storage::disk('private')->exists($attachment->path), 404);

        return Storage::disk('private')->download($attachment->path, $attachment->filename);
    }

    public function destroy(Task $task, TaskAttachment $attachment)
    {
        abort_unless($attachment->task_id === $task->id, 404);

        $user = auth()->user();
        $canDelete = $attachment->user_id === $user->id
            || $user->hasAnyRole(['super-admin', 'admin']);
        abort_unless($canDelete, 403);

        Storage::disk('private')->delete($attachment->path);
        $attachment->delete();

        return redirect()->route('admin.tasks.show', $task)->with('success', __('tasks.attach_deleted'));
    }
}
