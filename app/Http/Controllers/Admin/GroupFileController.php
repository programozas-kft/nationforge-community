<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class GroupFileController extends Controller
{
    private const MAX_KB = 20480; // 20 MB
    private const ALLOWED_MIMES = 'pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,zip,jpg,jpeg,png,gif,webp';

    public function store(Request $request, Group $group)
    {
        $request->validate([
            'file'        => 'required|file|max:' . self::MAX_KB . '|mimes:' . self::ALLOWED_MIMES,
            'description' => 'nullable|string|max:500',
        ]);

        $uploaded = $request->file('file');
        $path = $uploaded->store('group-files/' . $group->id, 'public');

        $group->files()->create([
            'uploaded_by'   => auth()->id(),
            'original_name' => $uploaded->getClientOriginalName(),
            'path'          => $path,
            'mime_type'     => $uploaded->getClientMimeType(),
            'size'          => $uploaded->getSize(),
            'description'   => $request->input('description'),
        ]);

        return back()->with('success', __('group_files.uploaded'));
    }

    public function download(Group $group, GroupFile $file): Response
    {
        abort_unless($file->group_id === $group->id, 404);
        abort_unless(Storage::disk('public')->exists($file->path), 404);

        return Storage::disk('public')->download($file->path, $file->original_name);
    }

    public function destroy(Group $group, GroupFile $file)
    {
        abort_unless($file->group_id === $group->id, 404);

        $user = auth()->user();
        if ($file->uploaded_by !== $user->id && ! $user->isAdmin()) {
            abort(403);
        }

        $file->delete();

        return back()->with('success', __('group_files.deleted'));
    }
}
