<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kriteria;
use App\Models\PerbandinganKriteria;
use App\Models\PenilaianAlternatif;

class PrioritasController extends Controller
{
    public function calculate()
    {
        // AHP Calculation

        //Mendapatkan Nilai Perbandingan
        $kriteria = Kriteria::all();
        $perbandinganKriteria = PerbandinganKriteria::all();
        
        //Membuat Matriks Perbandingan Berpasangan
        $n = count($kriteria);
        $pairwiseMatrix = array_fill(0, $n, array_fill(0, $n, 1.0));
        
        foreach ($perbandinganKriteria as $perbandingan) {
            $i = $perbandingan->kriteria_1_id - 1;
            $j = $perbandingan->kriteria_2_id - 1;
            $nilai = $perbandingan->nilai_perbandingan;
            $pairwiseMatrix[$i][$j] = $nilai;
            $pairwiseMatrix[$j][$i] = 1 / $nilai;
        }

        //Menghitung Jumlah Kolom
        $columnSums = array_fill(0, $n, 0.0);
        for ($j = 0; $j < $n; $j++) {
            for ($i = 0; $i < $n; $i++) {
                $columnSums[$j] += $pairwiseMatrix[$i][$j];
            }
        }

        //Normalisasi Matriks
        $normalizedMatrix = array_fill(0, $n, array_fill(0, $n, 0.0));
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalizedMatrix[$i][$j] = $pairwiseMatrix[$i][$j] / $columnSums[$j];
            }
        }   

        //Menghitung Rata-rata Baris (Eigenvector)
        $eigenVector = array_fill(0, $n, 0.0);
        for ($i = 0; $i < $n; $i++) {
            $sum = 0.0;
            for ($j = 0; $j < $n; $j++) {
                $sum += $normalizedMatrix[$i][$j];
            }
            $eigenVector[$i] = $sum / $n;
        }

        //Menghitung λ_max
        $lambdaMax = 0.0;
        for ($i = 0; $i < $n; $i++) {
            $sum = 0.0;
            for ($j = 0; $j < $n; $j++) {
                $sum += $pairwiseMatrix[$i][$j] * $eigenVector[$j];
            }
            $lambdaMax += $sum / $eigenVector[$i];
        }
        $lambdaMax /= $n;

        //Menghitung CI
        $ci = ($lambdaMax - $n) / ($n - 1);

        //Menghitung CR
        $ri = [0.0, 0.0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45];
        $cr = $ci / $ri[$n - 1];

        

        // MABAC Calculation



        $alternatif = DB::table('jenis_pengaduan')->get();
        $penilaianAlternatif = PenilaianAlternatif::all();

        $m = count($alternatif);
        $k = count($kriteria);

        // Membentuk matriks keputusan awal
        $decisionMatrix = [];
foreach ($penilaianAlternatif as $penilaian) {
    $decisionMatrix[$penilaian->id_jenis_pengaduan][$penilaian->kriteria_id] = $penilaian->nilai;
}


        // Normalisasi elemen matriks
        $normalizedMatrix = [];
        foreach ($decisionMatrix as $row) {
            $normalizedRow = [];
            foreach ($row as $key => $value) {
                if ($kriteria->find($key)->tipe == 'benefit') {
                    $normalizedRow[$key] = $value / max(array_column($decisionMatrix, $key));
                } else {
                    $normalizedRow[$key] = min(array_column($decisionMatrix, $key)) / $value;
                }
            }
            $normalizedMatrix[] = $normalizedRow;
        }

        // Matriks tertimbang
        $weightedMatrix = [];
        foreach ($normalizedMatrix as $row) {
            $weightedRow = [];
            foreach ($row as $key => $value) {
                $weightedRow[$key] = $value * $eigenVector[$key - 1];
            }
            $weightedMatrix[] = $weightedRow;
        }

        // Matriks area perkiraan perbatasan
        $gMatrix = array_fill(0, $k, 0);
        foreach ($weightedMatrix as $row) {
            foreach ($row as $key => $value) {
                $gMatrix[$key - 1] += $value;
            }
        }
        $gMatrix = array_map(function($val) use ($m) {
            return $val / $m;
        }, $gMatrix);

        // Matriks jarak alternatif
        $qMatrix = [];
        foreach ($weightedMatrix as $row) {
            $qRow = [];
            foreach ($row as $key => $value) {
                $qRow[$key] = $value - $gMatrix[$key - 1];
            }
            $qMatrix[] = $qRow;
        }

        // Hasil akhir MABAC
        $finalScores = array_map(function($row) {
            return array_sum($row);
        }, $qMatrix);

        return view('admin.prioritas.final', [
            'eigenVector' => $eigenVector,
            'lambdaMax' => $lambdaMax,
            'ci' => $ci,
            'cr' => $cr,
            'finalScores' => $finalScores,
        ]);
    }
}
