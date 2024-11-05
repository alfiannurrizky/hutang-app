<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class MonthlyDebtChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $monthlyDebts = DB::table('debts')
            ->select(DB::raw('SUM(total_amount) as total_hutang'), DB::raw('MONTH(created_at) as month'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = $monthlyDebts->pluck('month')->map(function ($month) {
            return date('F', mktime(0, 0, 0, $month, 10));
        });
        $totalDebts = $monthlyDebts->pluck('total_hutang');

        return (new LarapexChart)->barChart()
            ->setTitle('Laporan Hutang Bulanan')
            ->setSubtitle('Total Hutang per Bulan')
            ->addData('Total Hutang', $totalDebts->toArray())
            ->setXAxis($months->toArray())
            ->setFontColor(' #5477e2');
    }
}
