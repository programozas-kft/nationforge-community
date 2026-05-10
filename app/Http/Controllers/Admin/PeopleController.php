<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PeopleController extends Controller
{
    public function index()
    {
        $people = Person::with('groups')->orderBy('last_name')->paginate(25);
        $groups = \App\Models\Group::orderBy('name')->get();
        return view('admin.people.index', compact('people', 'groups'));
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
        return view('admin.people.show', compact('person'));
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
