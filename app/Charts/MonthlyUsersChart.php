<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class MonthlyUsersChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
{
    // Mengambil data total pengaduan yang selesai setiap bulan
    $monthlyData = DB::table('v_pengaduan')
        ->selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
        ->where('id_status_pengaduan', 4) // Anggap status 4 adalah status selesai
        ->groupBy(DB::raw('MONTH(updated_at)'))
        ->get();

    // Mengisi array $data dengan total pengaduan yang selesai setiap bulan
    $data = [];
    foreach ($monthlyData as $item) {
        $data[] = $item->total;
    }

    // Mendapatkan array nama bulan berdasarkan nilai bulan dari updated_at
    $monthNames = array_map(function ($month) {
        return date('F', mktime(0, 0, 0, $month, 1));
    }, $monthlyData->pluck('month')->toArray());

    // Menyusun data ke dalam chart
    return $this->chart->lineChart()
        ->setTitle('Total Pengaduan Selesai Setiap Bulan')
        ->setSubtitle(date('Y'))
        ->addData('Total', $data)
        ->setXAxis($monthNames);
}

}

