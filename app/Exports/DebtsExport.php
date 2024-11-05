<?php

namespace App\Exports;

use App\Models\Debt;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class DebtsExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{

    public function collection()
    {
        return DB::table('debts')
            ->select(DB::raw('SUM(total_amount) as total_hutang'), DB::raw('MONTH(created_at) as month'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($debt) {
                $debt->bulan = date('F', mktime(0, 0, 0, $debt->month, 1)); // Dapatkan nama bulan
                $debt->tanggal = now()->format('Y-m-d'); // Ambil tanggal saat ini
    
                return [
                    'Bulan' => $debt->bulan,
                    'Total Hutang' => number_format($debt->total_hutang),
                    'Tanggal' => $debt->tanggal,
                ];
            });
    }


    public function headings(): array
    {
        return [
            'Bulan',
            'Total Hutang',
            'Tanggal',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:C' . ($event->sheet->getHighestRow());

                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'ffff'],
                        ],
                    ],
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                ]);

                $headerRange = 'A1:C1';
                $event->sheet->getStyle($headerRange)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['argb' => 'FFDDDDDD'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'ffff'],
                        ],
                    ],
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ]);
            },
        ];

    }
}
