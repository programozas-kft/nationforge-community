<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['responsible', 'creator'])
            ->withCount(['tasks', 'tasks as kesz_count' => fn($q) => $q->where('status', 'kesz')])
            ->orderByRaw("FIELD(status, 'aktiv', 'tervezes', 'felfuggesztve', 'lezart')")
            ->orderByRaw("FIELD(priority, 'magas', 'kozepes', 'alacsony')")
            ->paginate(20);

        $counts = [
            'osszes'        => Project::count(),
            'aktiv'         => Project::where('status', 'aktiv')->count(),
            'tervezes'      => Project::where('status', 'tervezes')->count(),
            'lezart'        => Project::where('status', 'lezart')->count(),
        ];

        $users = User::orderBy('name')->get();

        return view('admin.projects.index', compact('projects', 'counts', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'status'         => 'required|in:tervezes,aktiv,lezart,felfuggesztve',
            'priority'       => 'required|in:alacsony,kozepes,magas',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'responsible_id' => 'nullable|exists:users,id',
        ]);

        $data['created_by'] = auth()->id();
        Project::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'Projekt sikeresen létrehozva!');
    }

    public function show(Project $project)
    {
        $project->load(['responsible', 'creator']);

        $tasks = $project->tasks()
            ->with(['assignedUser'])
            ->orderByRaw("FIELD(status, 'folyamatban', 'nyitott', 'kesz')")
            ->orderByRaw("FIELD(priority, 'surgos', 'magas', 'kozepes', 'alacsony')")
            ->get();

        $users = User::orderBy('name')->get();

        $taskCounts = [
            'osszes'      => $tasks->count(),
            'nyitott'     => $tasks->where('status', 'nyitott')->count(),
            'folyamatban' => $tasks->where('status', 'folyamatban')->count(),
            'kesz'        => $tasks->where('status', 'kesz')->count(),
        ];

        return view('admin.projects.show', compact('project', 'tasks', 'users', 'taskCounts'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'status'         => 'required|in:tervezes,aktiv,lezart,felfuggesztve',
            'priority'       => 'required|in:alacsony,kozepes,magas',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'responsible_id' => 'nullable|exists:users,id',
        ]);

        $project->update($data);

        return redirect()->route('admin.projects.show', $project)->with('success', 'Projekt frissítve!');
    }

    public function destroy(Project $project)
    {
        $project->tasks()->update(['project_id' => null]);
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Projekt törölve!');
    }
}
