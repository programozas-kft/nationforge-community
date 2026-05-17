<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Person;
use App\Services\WebhookService;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('person')->orderByDesc('created_at')->paginate(25);
        $total = Donation::where('status', 'completed')->sum('amount');
        $people = Person::orderBy('last_name')->orderBy('first_name')->get();
        return view('admin.donations.index', compact('donations', 'total', 'people'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'person_id'      => 'nullable|exists:people,id',
            'amount'         => 'required|numeric|min:1',
            'currency'       => 'required|in:HUF,EUR,USD',
            'status'         => 'required|in:completed,pending,failed,refunded',
            'payment_method' => 'nullable|in:card,transfer,cash,paypal,stripe,other',
            'campaign'       => 'nullable|string|max:100',
            'message'        => 'nullable|string',
            'is_recurring'   => 'boolean',
        ]);

        $data['is_recurring'] = $request->boolean('is_recurring');

        $donation = Donation::create($data);
        WebhookService::dispatch('donation.created', $donation->toArray());

        return redirect()->route('admin.donations.index')->with('success', 'Adomány sikeresen rögzítve!');
    }

    public function show(Donation $donation)
    {
        $donation->load('person');
        return view('admin.donations.show', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $data = $request->validate([
            'person_id'      => 'nullable|exists:people,id',
            'amount'         => 'required|numeric|min:1',
            'currency'       => 'required|in:HUF,EUR,USD',
            'status'         => 'required|in:completed,pending,failed,refunded',
            'payment_method' => 'nullable|in:card,transfer,cash,paypal,stripe,other',
            'campaign'       => 'nullable|string|max:100',
            'message'        => 'nullable|string',
            'is_recurring'   => 'boolean',
        ]);

        $data['is_recurring'] = $request->boolean('is_recurring');

        $donation->update($data);

        return redirect()->route('admin.donations.index')->with('success', 'Adomány frissítve!');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('admin.donations.index')->with('success', 'Adomány törölve!');
    }
}
