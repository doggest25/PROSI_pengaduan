<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use App\Models\Kriteria;
use App\Models\PerbandinganKriteria;

class AhpController extends Controller
{
    public function calculate()
    {
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
$ri = [0.0, 0.0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45]; // Nilai RI untuk matriks ukuran 1-9
$cr = $ci / $ri[$n - 1];


return view('admin.prioritas.index', [
    'eigenVector' => $eigenVector,
    'lambdaMax' => $lambdaMax,
    'ci' => $ci,
    'cr' => $cr,
]);

    } 
}


