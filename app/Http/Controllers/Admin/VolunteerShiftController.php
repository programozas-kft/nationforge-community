<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\VolunteerShift;
use App\Models\VolunteerSignup;
use Illuminate\Http\Request;

class VolunteerShiftController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'starts_at'   => 'required|date',
            'ends_at'     => 'required|date|after:starts_at',
            'location'    => 'nullable|string|max:200',
            'slots'       => 'required|integer|min:1|max:1000',
        ]);

        $data['event_id']   = $event->id;
        $data['created_by'] = auth()->id();

        VolunteerShift::create($data);

        return back()->with('success', __('shifts.created'));
    }

    public function update(Request $request, Event $event, VolunteerShift $shift)
    {
        abort_unless($shift->event_id === $event->id, 404);

        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'starts_at'   => 'required|date',
            'ends_at'     => 'required|date|after:starts_at',
            'location'    => 'nullable|string|max:200',
            'slots'       => 'required|integer|min:1|max:1000',
        ]);

        $shift->update($data);

        return back()->with('success', __('shifts.updated'));
    }

    public function destroy(Event $event, VolunteerShift $shift)
    {
        abort_unless($shift->event_id === $event->id, 404);

        $shift->delete();

        return back()->with('success', __('shifts.deleted'));
    }

    public function storeSignup(Request $request, Event $event, VolunteerShift $shift)
    {
        abort_unless($shift->event_id === $event->id, 404);

        $data = $request->validate([
            'person_id' => 'required|exists:people,id',
            'notes'     => 'nullable|string|max:500',
        ]);

        $exists = VolunteerSignup::where('shift_id', $shift->id)
            ->where('person_id', $data['person_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['person_id' => __('shifts.signup_exists')]);
        }

        $status = $shift->hasOpenSlot() ? 'confirmed' : 'waitlisted';

        VolunteerSignup::create([
            'shift_id'  => $shift->id,
            'person_id' => $data['person_id'],
            'status'    => $status,
            'notes'     => $data['notes'] ?? null,
        ]);

        $shift->recalcFilled();

        return back()->with('success', __($status === 'confirmed' ? 'shifts.signup_added' : 'shifts.signup_waitlisted'));
    }

    public function toggleAttended(Event $event, VolunteerShift $shift, VolunteerSignup $signup)
    {
        abort_unless($shift->event_id === $event->id && $signup->shift_id === $shift->id, 404);

        $signup->update(['attended' => ! $signup->attended]);

        return back();
    }

    public function destroySignup(Event $event, VolunteerShift $shift, VolunteerSignup $signup)
    {
        abort_unless($shift->event_id === $event->id && $signup->shift_id === $shift->id, 404);

        $signup->delete();
        $shift->recalcFilled();

        return back()->with('success', __('shifts.signup_removed'));
    }
}
