<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::orderBy('is_system', 'desc')->orderBy('name')->get();
        return view('admin.email_templates.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string|max:300',
            'category'    => 'required|in:minimal,newsletter,announcement,promotional,custom',
            'body_html'   => 'required|string',
        ]);

        EmailTemplate::create([
            'name'        => $request->name,
            'description' => $request->description,
            'category'    => $request->category,
            'body_html'   => $request->body_html,
            'is_system'   => false,
        ]);

        return redirect()->route('admin.email-templates.index')->with('success', __('campaigns.tpl_created'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string|max:300',
            'category'    => 'required|in:minimal,newsletter,announcement,promotional,custom',
            'body_html'   => 'required|string',
        ]);

        $emailTemplate->update([
            'name'        => $request->name,
            'description' => $request->description,
            'category'    => $request->category,
            'body_html'   => $request->body_html,
        ]);

        return redirect()->route('admin.email-templates.index')->with('success', __('campaigns.tpl_updated'));
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        abort_if($emailTemplate->is_system, 403, 'System templates cannot be deleted.');
        $emailTemplate->delete();
        return redirect()->route('admin.email-templates.index')->with('success', __('campaigns.tpl_deleted'));
    }

    public function preview(EmailTemplate $emailTemplate)
    {
        return response($emailTemplate->body_html)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function apiList()
    {
        return response()->json(
            EmailTemplate::orderBy('is_system', 'desc')->orderBy('name')
                ->get(['id', 'name', 'description', 'category', 'is_system', 'body_html'])
        );
    }
}
