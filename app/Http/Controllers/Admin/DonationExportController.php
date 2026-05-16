<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DonationExportController extends Controller
{
    public function export(Request $request)
    {
        $request->validate([
            'format'    => 'required|in:csv,xlsx,pdf',
            'status'    => 'nullable|in:completed,pending,failed,refunded',
            'date_from' => 'nullable|date',
            'date_to'   => 'nullable|date|after_or_equal:date_from',
            'campaign'  => 'nullable|string|max:100',
            'currency'  => 'nullable|in:HUF,EUR,USD',
        ]);

        $query = Donation::with('person')->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('campaign')) {
            $query->where('campaign', $request->campaign);
        }
        if ($request->filled('currency')) {
            $query->where('currency', $request->currency);
        }

        $donations = $query->get();
        $format    = $request->format;
        $filename  = 'donations_' . date('Y-m-d');

        return match ($format) {
            'csv'  => $this->exportCsv($donations, $filename),
            'xlsx' => $this->exportXlsx($donations, $filename),
            'pdf'  => $this->exportPdf($donations, $filename, $request),
        };
    }

    private function donorName(Donation $d): string
    {
        if ($d->person) {
            return trim($d->person->last_name . ' ' . $d->person->first_name);
        }
        if ($d->is_anonymous) {
            return '(anonymous)';
        }
        return $d->donor_name ?? '—';
    }

    private function heading(): array
    {
        return [
            'ID', 'Date', 'Donor', 'Email', 'Amount', 'Currency',
            'Status', 'Payment method', 'Campaign', 'Recurring', 'Transaction ID', 'Message',
        ];
    }

    private function rows($donations): array
    {
        return $donations->map(fn(Donation $d) => [
            $d->id,
            $d->created_at->format('Y-m-d'),
            $this->donorName($d),
            $d->person?->email ?? $d->donor_email ?? '',
            number_format($d->amount, 2, '.', ''),
            $d->currency,
            $d->status,
            $d->payment_method ?? '',
            $d->campaign ?? '',
            $d->is_recurring ? 'yes' : 'no',
            $d->transaction_id ?? '',
            $d->message ?? '',
        ])->toArray();
    }

    private function exportCsv($donations, string $filename)
    {
        $heading = $this->heading();
        $rows    = $this->rows($donations);

        return response()->streamDownload(function () use ($heading, $rows) {
            $h = fopen('php://output', 'w');
            fputs($h, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel compatibility
            fputcsv($h, $heading, ';');
            foreach ($rows as $row) {
                fputcsv($h, $row, ';');
            }
            fclose($h);
        }, $filename . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function exportXlsx($donations, string $filename)
    {
        $heading = $this->heading();
        $rows    = $this->rows($donations);
        $all     = [$heading, ...$rows];
        $colCount = count($heading);
        $rowCount = count($all);

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Donations');
        $sheet->fromArray($all);

        // Header row styling
        $lastCol = chr(ord('A') + $colCount - 1);
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '405189']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
        ]);

        // Data rows alternating background
        for ($r = 2; $r <= $rowCount; $r++) {
            if ($r % 2 === 0) {
                $sheet->getStyle("A{$r}:{$lastCol}{$r}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F8F9FF');
            }
        }

        // Auto-size columns
        foreach (range('A', $lastCol) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Amount column (E) right-aligned
        $sheet->getStyle("E2:E{$rowCount}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $writer = new Xlsx($spreadsheet);
        return response()->streamDownload(
            fn() => $writer->save('php://output'),
            $filename . '.xlsx',
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }

    private function exportPdf($donations, string $filename, Request $request)
    {
        $orgName = Setting::get('brand_org_name', config('app.name'));

        // Totals by currency for completed donations
        $totals = $donations->where('status', 'completed')
            ->groupBy('currency')
            ->map(fn($group, $currency) => [
                'currency' => $currency,
                'sum'      => $group->sum('amount'),
                'count'    => $group->count(),
            ])->values();

        $filters = array_filter([
            'Status'    => $request->status,
            'From'      => $request->date_from,
            'To'        => $request->date_to,
            'Campaign'  => $request->campaign,
            'Currency'  => $request->currency,
        ]);

        $pdf = Pdf::loadView('admin.donations.export_pdf', [
            'donations' => $donations,
            'orgName'   => $orgName,
            'totals'    => $totals,
            'filters'   => $filters,
            'generatedAt' => now()->format('Y-m-d H:i'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download($filename . '.pdf');
    }
}
