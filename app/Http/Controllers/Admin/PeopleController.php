<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactActivity;
use App\Models\Person;
use App\Models\PeopleSavedFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PeopleController extends Controller
{
    public function index(Request $request)
    {
        $query = Person::with('groups')->orderBy('last_name')->orderBy('first_name');

        if ($q = $request->input('q')) {
            $query->where(function ($b) use ($q) {
                $b->whereRaw("CONCAT(last_name,' ',first_name) LIKE ?", ["%{$q}%"])
                  ->orWhereRaw("CONCAT(first_name,' ',last_name) LIKE ?", ["%{$q}%"])
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('phone', 'like', "%{$q}%");
            });
        }

        if ($statuses = $request->input('status')) {
            $query->whereIn('status', (array) $statuses);
        }

        if ($city = $request->input('city')) {
            $query->where('city', 'like', "%{$city}%");
        }

        if ($source = $request->input('source')) {
            $query->where('source', 'like', "%{$source}%");
        }

        if ($request->filled('subscribed')) {
            $query->where('is_subscribed', (bool) $request->input('subscribed'));
        }

        if ($groupId = $request->input('group_id')) {
            $query->whereHas('groups', fn ($g) => $g->where('groups.id', $groupId));
        }

        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        if ($leadStage = $request->input('lead_stage')) {
            $query->where('lead_stage', $leadStage);
        }

        if ($leadScoreMin = $request->input('lead_score_min')) {
            $query->where('lead_score', '>=', (int) $leadScoreMin);
        }

        $people       = $query->paginate(25)->withQueryString();
        $groups       = \App\Models\Group::orderBy('name')->get();
        $savedFilters = PeopleSavedFilter::where('user_id', auth()->id())->orderBy('name')->get();
        $filters      = $request->only(['q','status','city','source','subscribed','group_id','date_from','date_to','lead_stage','lead_score_min']);

        return view('admin.people.index', compact('people', 'groups', 'savedFilters', 'filters'));
    }

    public function saveFilter(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'filters' => 'required|array',
        ]);

        PeopleSavedFilter::updateOrCreate(
            ['user_id' => auth()->id(), 'name' => $request->input('name')],
            ['filters' => $request->input('filters')]
        );

        return back()->with('success', 'Szűrő mentve: ' . $request->input('name'));
    }

    public function deleteFilter(PeopleSavedFilter $filter)
    {
        abort_unless($filter->user_id === auth()->id(), 403);
        $filter->delete();
        return back()->with('success', 'Szűrő törölve.');
    }

    public function create()
    {
        $groups = \App\Models\Group::orderBy('name')->get();
        return view('admin.people.form', ['person' => new Person(), 'groups' => $groups]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => 'nullable|email|unique:people,email',
            'phone'         => 'nullable|string|max:30',
            'city'          => 'nullable|string|max:100',
            'status'        => 'required|in:prospect,supporter,member,volunteer,donor,vip,inactive',
            'is_subscribed' => 'boolean',
            'notes'         => 'nullable|string',
            'source'        => 'nullable|string|max:100',
            'photo'         => 'nullable|image|max:2048',
            'groups'        => 'nullable|array',
            'groups.*'      => 'exists:groups,id',
        ]);

        $data['is_subscribed'] = $request->boolean('is_subscribed');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = uniqid('p_') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/people', $filename, 'public');
            $data['photo'] = 'uploads/people/' . $filename;
        }

        $person = Person::create($data);
        
        if (isset($data['groups'])) {
            $person->groups()->sync($data['groups']);
        }

        return redirect()->route('admin.people.index')->with('success', 'Kapcsolat sikeresen létrehozva!');
    }

    public function show(Person $person)
    {
        $person->load('donations', 'groups');
        $activities = ContactActivity::where('person_id', $person->id)
            ->with('user')
            ->orderByDesc('occurred_at')
            ->get();
        return view('admin.people.show', compact('person', 'activities'));
    }

    public function logActivity(Request $request, Person $person)
    {
        $data = $request->validate([
            'type'        => 'required|in:call,email,meeting,note,task,sms,other',
            'notes'       => 'nullable|string|max:2000',
            'occurred_at' => 'required|date',
        ]);
        $data['person_id'] = $person->id;
        $data['user_id']   = auth()->id();

        ContactActivity::create($data);

        return back()->with('success', 'Aktivitás rögzítve.');
    }

    public function deleteActivity(Person $person, ContactActivity $activity)
    {
        abort_unless($activity->person_id === $person->id, 403);
        $activity->delete();
        return back()->with('success', 'Aktivitás törölve.');
    }

    public function updateLead(Request $request, Person $person)
    {
        $data = $request->validate([
            'lead_stage' => 'nullable|in:new,contacted,qualified,proposal,converted,lost',
            'lead_score' => 'nullable|integer|min:1|max:5',
        ]);

        // Allow explicitly clearing fields
        $person->lead_stage = $data['lead_stage'] ?? null;
        $person->lead_score = isset($data['lead_score']) ? (int) $data['lead_score'] : null;
        $person->save();

        return back()->with('success', 'Értékelés mentve.');
    }

    public function edit(Person $person)
    {
        $groups = \App\Models\Group::orderBy('name')->get();
        return view('admin.people.form', compact('person', 'groups'));
    }

    public function update(Request $request, Person $person)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => 'nullable|email|unique:people,email,' . $person->id,
            'phone'         => 'nullable|string|max:30',
            'city'          => 'nullable|string|max:100',
            'status'        => 'required|in:prospect,supporter,member,volunteer,donor,vip,inactive',
            'is_subscribed' => 'boolean',
            'notes'         => 'nullable|string',
            'source'        => 'nullable|string|max:100',
            'photo'         => 'nullable|image|max:2048',
            'groups'        => 'nullable|array',
            'groups.*'      => 'exists:groups,id',
        ]);

        $data['is_subscribed'] = $request->boolean('is_subscribed');

        if ($request->hasFile('photo')) {
            if ($person->photo) {
                Storage::disk('public')->delete($person->photo);
            }
            $file = $request->file('photo');
            $filename = uniqid('p_') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/people', $filename, 'public');
            $data['photo'] = 'uploads/people/' . $filename;
        }

        $person->update($data);

        if (isset($data['groups'])) {
            $person->groups()->sync($data['groups']);
        } else {
            $person->groups()->sync([]);
        }

        return redirect()->route('admin.people.index')->with('success', 'Kapcsolat frissítve!');
    }

    public function destroy(Person $person)
    {
        if ($person->photo) {
            Storage::disk('public')->delete($person->photo);
        }
        $person->delete();
        return redirect()->route('admin.people.index')->with('success', 'Kapcsolat törölve!');
    }

    public function duplicates()
    {
        $pairMap = []; // plain PHP array — safe with use (&$ref)

        $addPair = function (int $id1, int $id2, string $reason) use (&$pairMap) {
            $a = min($id1, $id2);
            $b = max($id1, $id2);
            $key = "{$a}_{$b}";
            if (!isset($pairMap[$key])) {
                $pairMap[$key] = ['ids' => [$a, $b], 'reasons' => []];
            }
            if (!in_array($reason, $pairMap[$key]['reasons'], true)) {
                $pairMap[$key]['reasons'][] = $reason;
            }
        };

        // ── Email matches (SQL GROUP BY on real column) ──────
        Person::whereNotNull('email')
            ->where('email', '!=', '')
            ->select('id', 'email')
            ->orderBy('created_at')
            ->get()
            ->groupBy('email')
            ->each(function ($group) use ($addPair) {
                if ($group->count() < 2) return;
                $ids = $group->pluck('id')->values();
                for ($i = 0; $i < $ids->count(); $i++) {
                    for ($j = $i + 1; $j < $ids->count(); $j++) {
                        $addPair($ids[$i], $ids[$j], 'email');
                    }
                }
            });

        // ── Phone matches ────────────────────────────────────
        Person::whereNotNull('phone')
            ->where('phone', '!=', '')
            ->select('id', 'phone')
            ->orderBy('created_at')
            ->get()
            ->groupBy('phone')
            ->each(function ($group) use ($addPair) {
                if ($group->count() < 2) return;
                $ids = $group->pluck('id')->values();
                for ($i = 0; $i < $ids->count(); $i++) {
                    for ($j = $i + 1; $j < $ids->count(); $j++) {
                        $addPair($ids[$i], $ids[$j], 'phone');
                    }
                }
            });

        // ── Name matches (PHP-side grouping — no SQL alias) ──
        Person::select('id', 'first_name', 'last_name')
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($p) {
                return mb_strtolower(trim($p->first_name)) . '|' . mb_strtolower(trim($p->last_name));
            })
            ->each(function ($group) use ($addPair) {
                if ($group->count() < 2) return;
                $ids = $group->pluck('id')->values();
                for ($i = 0; $i < $ids->count(); $i++) {
                    for ($j = $i + 1; $j < $ids->count(); $j++) {
                        $addPair($ids[$i], $ids[$j], 'name');
                    }
                }
            });

        if (empty($pairMap)) {
            return view('admin.people.duplicates', ['pairs' => collect()]);
        }

        // ── Load Person models ───────────────────────────────
        $allIds = collect($pairMap)->flatMap(fn ($p) => $p['ids'])->unique()->values();
        $people = Person::whereIn('id', $allIds)->with('groups')->get()->keyBy('id');

        $pairs = collect($pairMap)
            ->map(fn ($p) => [
                'reasons' => $p['reasons'],
                'a'       => $people->get($p['ids'][0]),
                'b'       => $people->get($p['ids'][1]),
            ])
            ->filter(fn ($p) => $p['a'] && $p['b'])
            ->values();

        return view('admin.people.duplicates', compact('pairs'));
    }

    public function merge(Request $request)
    {
        $request->validate([
            'master_id'    => 'required|exists:people,id',
            'duplicate_id' => 'required|exists:people,id|different:master_id',
        ]);

        $master = Person::findOrFail($request->master_id);
        $dupe   = Person::findOrFail($request->duplicate_id);

        // Fill blank fields on master from duplicate
        $fields = [
            'email','phone','mobile','city','county','postal_code','address',
            'birthdate','gender','occupation','employer','bio',
            'facebook_url','twitter_url','linkedin_url','website','source','notes',
        ];
        foreach ($fields as $field) {
            if (empty($master->$field) && !empty($dupe->$field)) {
                $master->$field = $dupe->$field;
            }
        }
        // Combine donation stats
        $master->total_donated  = (float) $master->total_donated + (float) $dupe->total_donated;
        $master->donation_count = (int)   $master->donation_count + (int)   $dupe->donation_count;
        if ($dupe->last_donated_at && (!$master->last_donated_at || $dupe->last_donated_at > $master->last_donated_at)) {
            $master->last_donated_at = $dupe->last_donated_at;
        }
        // Subscribe if either was subscribed
        $master->is_subscribed = $master->is_subscribed || $dupe->is_subscribed;
        $master->save();

        // Transfer donations
        DB::table('donations')->where('person_id', $dupe->id)->update(['person_id' => $master->id]);

        // Transfer event RSVPs (skip if master already has one for the same event)
        $masterEventIds = DB::table('event_rsvps')->where('person_id', $master->id)->pluck('event_id')->toArray();
        DB::table('event_rsvps')
            ->where('person_id', $dupe->id)
            ->whereNotIn('event_id', $masterEventIds)
            ->update(['person_id' => $master->id]);
        DB::table('event_rsvps')->where('person_id', $dupe->id)->delete();

        // Transfer groups
        $dupeGroupIds = DB::table('group_person')->where('person_id', $dupe->id)->pluck('group_id');
        foreach ($dupeGroupIds as $gid) {
            DB::table('group_person')->insertOrIgnore(['group_id' => $gid, 'person_id' => $master->id, 'joined_at' => now()]);
        }
        DB::table('group_person')->where('person_id', $dupe->id)->delete();

        $dupeName = $dupe->last_name . ' ' . $dupe->first_name;
        $dupe->delete();

        return redirect()->route('admin.people.duplicates')
            ->with('success', "Összevonva. {$dupeName} törölve, adatai átkerültek.");
    }

    public function export(Request $request)
    {
        $format  = $request->get('format', 'csv');
        $people  = Person::orderBy('last_name')->orderBy('first_name')->get();
        $heading = ['Vezetéknév','Keresztnév','Email','Telefon','Mobil','Város','Megye','Irányítószám','Státusz','Hírlevél','Forrás','Megjegyzés','Létrehozva'];

        $rows = $people->map(fn($p) => [
            $p->last_name, $p->first_name, $p->email, $p->phone, $p->mobile,
            $p->city, $p->county, $p->postal_code, $p->status,
            $p->is_subscribed ? '1' : '0', $p->source, $p->notes,
            $p->created_at->format('Y-m-d'),
        ])->toArray();

        $filename = 'kapcsolatok_' . date('Y-m-d');

        if ($format === 'xlsx') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray([$heading, ...$rows]);

            // Bold header row
            $sheet->getStyle('A1:M1')->getFont()->setBold(true);
            foreach (range('A', 'M') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            return response()->streamDownload(
                fn() => $writer->save('php://output'),
                $filename . '.xlsx',
                ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
            );
        }

        return response()->streamDownload(function () use ($heading, $rows) {
            $h = fopen('php://output', 'w');
            fputs($h, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel
            fputcsv($h, $heading, ';');
            foreach ($rows as $row) {
                fputcsv($h, $row, ';');
            }
            fclose($h);
        }, $filename . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt,xlsx,xls|max:10240']);

        $file = $request->file('file');
        $ext  = strtolower($file->getClientOriginalExtension());
        $rows = [];

        if (in_array($ext, ['xlsx', 'xls'])) {
            $spreadsheet = IOFactory::load($file->path());
            $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
        } else {
            $h = fopen($file->path(), 'r');
            $bom = fread($h, 3);
            if ($bom !== "\xEF\xBB\xBF") {
                rewind($h);
            }
            while (($row = fgetcsv($h, 0, ';')) !== false) {
                $rows[] = $row;
            }
            fclose($h);
        }

        if (empty($rows)) {
            return back()->with('error', 'A fájl üres.');
        }

        $header = array_shift($rows);
        $header = array_map('trim', $header);

        $colMap = [
            'Vezetéknév' => 'last_name',   'Keresztnév' => 'first_name',
            'Email'      => 'email',        'Telefon'    => 'phone',
            'Mobil'      => 'mobile',       'Város'      => 'city',
            'Megye'      => 'county',       'Irányítószám' => 'postal_code',
            'Státusz'    => 'status',       'Hírlevél'   => 'is_subscribed',
            'Forrás'     => 'source',       'Megjegyzés' => 'notes',
        ];

        $map = [];
        foreach ($header as $idx => $col) {
            if (isset($colMap[$col])) {
                $map[$colMap[$col]] = $idx;
            }
        }

        if (!isset($map['last_name'], $map['first_name'])) {
            return back()->with('error', 'Hiányzó kötelező oszlopok: Vezetéknév, Keresztnév. Töltsd le a sablont az exportból.');
        }

        $validStatuses = ['prospect','supporter','member','volunteer','donor','vip','inactive'];
        $imported = $skipped = $errors = 0;

        foreach ($rows as $row) {
            $row      = array_values((array) $row);
            $lastName  = trim($row[$map['last_name']]  ?? '');
            $firstName = trim($row[$map['first_name']] ?? '');
            if (!$lastName && !$firstName) continue;

            $email = isset($map['email']) ? (trim($row[$map['email']] ?? '') ?: null) : null;

            if ($email && Person::where('email', $email)->exists()) {
                $skipped++;
                continue;
            }

            $status = isset($map['status']) ? trim($row[$map['status']] ?? '') : 'prospect';
            if (!in_array($status, $validStatuses)) $status = 'prospect';

            $isSubscribed = isset($map['is_subscribed'])
                ? (trim($row[$map['is_subscribed']] ?? '0') === '1')
                : true;

            try {
                Person::create([
                    'last_name'     => $lastName,
                    'first_name'    => $firstName,
                    'email'         => $email,
                    'phone'         => isset($map['phone'])       ? (trim($row[$map['phone']]       ?? '') ?: null) : null,
                    'mobile'        => isset($map['mobile'])      ? (trim($row[$map['mobile']]      ?? '') ?: null) : null,
                    'city'          => isset($map['city'])        ? (trim($row[$map['city']]        ?? '') ?: null) : null,
                    'county'        => isset($map['county'])      ? (trim($row[$map['county']]      ?? '') ?: null) : null,
                    'postal_code'   => isset($map['postal_code']) ? (trim($row[$map['postal_code']] ?? '') ?: null) : null,
                    'status'        => $status,
                    'is_subscribed' => $isSubscribed,
                    'source'        => isset($map['source'])  ? (trim($row[$map['source']]  ?? '') ?: null) : null,
                    'notes'         => isset($map['notes'])   ? (trim($row[$map['notes']]   ?? '') ?: null) : null,
                ]);
                $imported++;
            } catch (\Exception) {
                $errors++;
            }
        }

        $msg = "{$imported} kapcsolat importálva";
        if ($skipped) $msg .= ", {$skipped} kihagyva (email már létezik)";
        if ($errors)  $msg .= ", {$errors} sor hibás";

        return back()->with('success', $msg);
    }
}
