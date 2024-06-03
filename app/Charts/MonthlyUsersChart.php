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

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Mengambil data total pengaduan yang selesai setiap bulan
        $monthlyData = DB::table('v_pengaduan')
            ->selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
            ->where('id_status_pengaduan', 4) // Anggap status 4 adalah status selesai
            ->groupBy(DB::raw('MONTH(updated_at)'))
            ->get();

        $data = array_fill(1, 12, 0);

        foreach ($monthlyData as $item) {
            $data[$item->month] = $item->total;
        }

        $monthNames = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthNames[] = date('F', mktime(0, 0, 0, $i, 1));
        }

        return $this->chart->barChart()
            ->setTitle('Total Pengaduan Selesai Setiap Bulan')
            ->setSubtitle('Tahun ' . date('Y'))
            ->addData('Total', array_values($data))
            ->setXAxis($monthNames);
    }
}
