<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PenilaianAlternatif;
use Illuminate\Http\Request;

class MABACController extends Controller
{
    public function hitungMABAC()
    {
        $penilaianAlternatif = PenilaianAlternatif::with(['jenisPengaduan', 'kriteria'])->get();

        // Proses perhitungan MABAC disini
        $hasilAkhir = $this->calculateMABAC($penilaianAlternatif);

        return view('hasil_mabac', compact('hasilAkhir'));
    }

    private function calculateMABAC($penilaianAlternatif)
    {
        // Implementasikan logika perhitungan MABAC disini
        // Contoh struktur data hasil perhitungan (sesuaikan dengan kebutuhan)
        $hasilAkhir = [
            // ['jenis_pengaduan_id' => 1, 'nilai_mabac' => 0.75],
            // ['jenis_pengaduan_id' => 2, 'nilai_mabac' => 0.65],
            // ...
        ];

        return $hasilAkhir;
    }
}

