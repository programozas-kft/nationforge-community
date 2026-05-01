<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['assignedUser', 'creator', 'project'])
            ->orderByRaw("FIELD(priority, 'surgos', 'magas', 'kozepes', 'alacsony')")
            ->orderBy('due_date');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $tasks = $query->paginate(25)->withQueryString();
        $users    = User::orderBy('name')->get();
        $projects = Project::orderBy('title')->get();

        $counts = [
            'osszes'      => Task::count(),
            'nyitott'     => Task::where('status', 'nyitott')->count(),
            'folyamatban' => Task::where('status', 'folyamatban')->count(),
            'kesz'        => Task::where('status', 'kesz')->count(),
        ];

        return view('admin.tasks.index', compact('tasks', 'users', 'projects', 'counts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:nyitott,folyamatban,kesz',
            'priority'    => 'required|in:alacsony,kozepes,magas,surgos',
            'due_date'    => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'project_id'  => 'nullable|exists:projects,id',
        ]);

        $data['created_by'] = auth()->id();

        if ($data['status'] === 'kesz') {
            $data['completed_at'] = now();
        }

        Task::create($data);

        return redirect()->route('admin.tasks.index')->with('success', 'Feladat sikeresen létrehozva!');
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:nyitott,folyamatban,kesz',
            'priority'    => 'required|in:alacsony,kozepes,magas,surgos',
            'due_date'    => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'project_id'  => 'nullable|exists:projects,id',
        ]);

        if ($data['status'] === 'kesz' && $task->status !== 'kesz') {
            $data['completed_at'] = now();
        } elseif ($data['status'] !== 'kesz') {
            $data['completed_at'] = null;
        }

        $task->update($data);

        return redirect()->route('admin.tasks.index')->with('success', 'Feladat frissítve!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate(['status' => 'required|in:nyitott,folyamatban,kesz']);

        $task->status = $request->status;
        $task->completed_at = $request->status === 'kesz' ? now() : null;
        $task->save();

        return back()->with('success', 'Státusz frissítve!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Feladat törölve!');
    }
}
