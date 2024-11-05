<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyDebtChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(MonthlyDebtChart $chart)
    {
        $totalCustomers = DB::table('customers')->count();

        $totalHutang = DB::table('debts')->sum('total_amount');

        $totalHutangBulanIni = DB::table('debts')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_amount');

        $totalProducts = DB::table('products')->count();

        return view('home', [
            'chart' => $chart->build(),
            'totalCustomers' => $totalCustomers,
            'totalHutang' => $totalHutang,
            'totalHutangBulanIni' => $totalHutangBulanIni,
            'totalProducts' => $totalProducts,
        ]);
    }
}
