<?php

namespace App\Http\Controllers;

use App\Mail\DonationConfirmationMail;
use App\Models\Donation;
use App\Models\Setting;
use App\Services\BarionPaymentService;
use App\Services\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DonationFormController extends Controller
{
    public function show()
    {
        abort_unless(Setting::get('donation_page_enabled', '0') === '1', 404);

        $config = $this->pageConfig();
        return view('public.donate.form', compact('config'));
    }

    public function submit(Request $request)
    {
        abort_unless(Setting::get('donation_page_enabled', '0') === '1', 404);

        $data = $request->validate([
            'amount'    => 'required|numeric|min:100|max:9999999',
            'currency'  => 'required|in:HUF,EUR,USD',
            'name'      => 'nullable|string|max:150',
            'email'     => 'nullable|email|max:150',
            'message'   => 'nullable|string|max:1000',
            'anonymous' => 'nullable|boolean',
        ]);

        $anonymous = $request->boolean('anonymous');
        $provider  = Setting::get('payment_provider', '');
        $token     = Str::random(40);

        $donation = Donation::create([
            'token'          => $token,
            'donor_name'     => $anonymous ? null : ($data['name']  ?? null),
            'donor_email'    => $anonymous ? null : ($data['email'] ?? null),
            'amount'         => $data['amount'],
            'currency'       => $data['currency'],
            'status'         => 'pending',
            'payment_method' => match ($provider) {
                'stripe' => 'stripe',
                'barion' => 'other',
                default  => 'transfer',
            },
            'campaign'       => Setting::get('donation_campaign') ?: null,
            'message'        => $data['message'] ?? null,
            'is_anonymous'   => $anonymous,
        ]);

        if ($provider === 'stripe') {
            try {
                $url = (new StripePaymentService())->createDonationSession($donation);
                return redirect($url);
            } catch (\Throwable $e) {
                Log::error('Donation Stripe session failed', ['error' => $e->getMessage()]);
                $donation->delete();
                return back()->with('payment_error', __('donations.payment_error'));
            }
        }

        if ($provider === 'barion') {
            try {
                $url = (new BarionPaymentService())->createDonationPayment($donation);
                if ($url) {
                    return redirect($url);
                }
            } catch (\Throwable $e) {
                Log::error('Donation Barion payment failed', ['error' => $e->getMessage()]);
            }
            $donation->delete();
            return back()->with('payment_error', __('donations.payment_error'));
        }

        // No payment provider — show thanks with transfer instructions
        return redirect()->route('donate.thanks', $token);
    }

    public function thanks(string $token)
    {
        $donation = Donation::where('token', $token)->firstOrFail();
        $config   = $this->pageConfig();
        $provider = Setting::get('payment_provider', '');
        $bankDetails = [
            'name' => Setting::get('donation_bank_name', ''),
            'iban' => Setting::get('donation_bank_iban', ''),
            'note' => Setting::get('donation_bank_note', ''),
        ];
        return view('public.donate.thanks', compact('donation', 'config', 'provider', 'bankDetails'));
    }

    private function pageConfig(): array
    {
        $rawPresets = Setting::get('donation_presets', '1000,2000,5000,10000');
        $presets    = array_values(array_filter(array_map('intval', explode(',', $rawPresets))));

        return [
            'title'       => Setting::get('donation_page_title', __('donations.public_title')),
            'description' => Setting::get('donation_page_description', ''),
            'presets'     => $presets,
            'currency'    => Setting::get('donation_currency', 'HUF'),
            'campaign'    => Setting::get('donation_campaign', ''),
            'org_name'    => Setting::get('brand_org_name', config('app.name')),
        ];
    }

    public static function sendConfirmation(Donation $donation): void
    {
        if (!$donation->donor_email) {
            return;
        }
        try {
            Mail::to($donation->donor_email, $donation->donor_name ?? $donation->donor_email)
                ->send(new DonationConfirmationMail($donation));
        } catch (\Throwable $e) {
            Log::warning('Donation confirmation email failed', [
                'donation_id' => $donation->id,
                'error'       => $e->getMessage(),
            ]);
        }
    }
}
