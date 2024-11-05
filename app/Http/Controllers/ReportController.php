<?php

namespace App\Http\Controllers;

use App\Exports\DebtsExport;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function downloadReport()
    {
        $monthlyDebts = DB::table('debts')
            ->select(DB::raw('SUM(total_amount) as total_hutang'), DB::raw('MONTH(created_at) as month'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = $monthlyDebts->pluck('month')->map(function ($month) {
            return date('F', mktime(0, 0, 0, $month, 10));
        })->toArray();
        $totalDebts = $monthlyDebts->pluck('total_hutang')->toArray();

        $pdf = Pdf::loadView('admin.report.pdf.index', compact('months', 'totalDebts'));

        return $pdf->download('laporan_hutang_bulanan.pdf');
    }

    public function downloadExcel()
    {
        return Excel::download(new DebtsExport, 'laporan_hutang_bulanan.xlsx');
    }
}
