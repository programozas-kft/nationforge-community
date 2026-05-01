<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('person')->orderByDesc('created_at')->paginate(25);
        $total = Donation::where('status', 'completed')->sum('amount');
        return view('admin.donations.index', compact('donations', 'total'));
    }

    public function show(Donation $donation)
    {
        $donation->load('person');
        return view('admin.donations.show', compact('donation'));
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('admin.donations.index')->with('success', 'Adomány törölve!');
    }
}
