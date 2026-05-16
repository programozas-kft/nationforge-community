<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::query()->orderByDesc('created_at');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        if ($request->filled('type')) {
            $query->where('auditable_type', $request->type);
        }
        if ($request->filled('user')) {
            $query->where('user_name', 'like', '%' . $request->user . '%');
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $logs = $query->paginate(50)->withQueryString();

        $types    = AuditLog::distinct()->orderBy('auditable_type')->pluck('auditable_type');
        $actions  = ['created', 'updated', 'deleted', 'restored'];

        return view('admin.audit.index', compact('logs', 'types', 'actions'));
    }
}
