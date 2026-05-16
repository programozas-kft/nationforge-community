<?php

namespace App\Http\Controllers;

use App\Models\DripSend;
use App\Models\EmailSend;
use App\Services\EmailTrackingService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackingController extends Controller
{
    public function open(string $token): Response
    {
        $send = EmailSend::where('tracking_token', $token)->first()
            ?? DripSend::where('tracking_token', $token)->first();

        if ($send && !$send->opened_at) {
            $send->update(['opened_at' => now()]);

            if ($send instanceof EmailSend) {
                $send->campaign?->increment('opened_count');
            }
        }

        return response(base64_decode(EmailTrackingService::PIXEL_GIF), 200, [
            'Content-Type'  => 'image/gif',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma'        => 'no-cache',
            'Expires'       => '0',
        ]);
    }

    public function click(string $token, Request $request): Response
    {
        $destination = rawurldecode($request->query('to', ''));

        $send = EmailSend::where('tracking_token', $token)->first()
            ?? DripSend::where('tracking_token', $token)->first();

        if ($send && !$send->clicked_at) {
            $send->update(['clicked_at' => now()]);

            if ($send instanceof EmailSend) {
                $send->campaign?->increment('clicked_count');
            }
        }

        if (!$destination || !filter_var($destination, FILTER_VALIDATE_URL)) {
            return redirect('/');
        }

        return redirect($destination);
    }
}
