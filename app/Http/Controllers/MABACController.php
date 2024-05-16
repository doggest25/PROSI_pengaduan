<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PenilaianAlternatif;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MABACController extends Controller
{
    public function hitungMABAC()
    {
        // Ambil data penilaian alternatif dan kriteria beserta bobotnya
        $penilaianAlternatif = PenilaianAlternatif::with('kriteria')->get();
        $kriteria = Kriteria::all();

        // Matriks keputusan awal (X)
        $matriksKeputusan = [];
        foreach ($penilaianAlternatif as $penilaian) {
            $matriksKeputusan[$penilaian->id_jenis_pengaduan][$penilaian->kriteria_id] = $penilaian->nilai;
        }

        // Debug: Log matriks keputusan awal
        Log::info('Matriks Keputusan Awal: ', $matriksKeputusan);

        // Normalisasi matriks (R)
        $matriksNormalisasi = [];
        foreach ($kriteria as $k) {
            $nilaiKriteria = array_column($matriksKeputusan, $k->id);
            $max = max($nilaiKriteria);
            $min = min($nilaiKriteria);

            foreach ($matriksKeputusan as $jenisPengaduanId => $nilai) {
                if ($k->jenis == 'benefit') {
                    $matriksNormalisasi[$jenisPengaduanId][$k->id] = $nilai[$k->id] / $max;
                } else {
                    $matriksNormalisasi[$jenisPengaduanId][$k->id] = $min / $nilai[$k->id];
                }
            }
        }

        // Debug: Log matriks normalisasi
        Log::info('Matriks Normalisasi: ', $matriksNormalisasi);

        // Matriks tertimbang (V)
        $matriksTertimbang = [];
        foreach ($matriksNormalisasi as $jenisPengaduanId => $nilai) {
            foreach ($nilai as $kriteriaId => $r) {
                $bobot = $kriteria->where('id', $kriteriaId)->first()->bobot;
                $matriksTertimbang[$jenisPengaduanId][$kriteriaId] = $r * $bobot;
            }
        }

        // Debug: Log matriks tertimbang
        Log::info('Matriks Tertimbang: ', $matriksTertimbang);

        // Matriks area perkiraan perbatasan (G)
        $matriksPerkiraan = [];
        foreach ($kriteria as $k) {
            $sum = array_sum(array_column($matriksTertimbang, $k->id));
            $matriksPerkiraan[$k->id] = $sum / count($matriksTertimbang);
        }

        // Debug: Log matriks area perkiraan perbatasan
        Log::info('Matriks Area Perkiraan Perbatasan: ', $matriksPerkiraan);

        // Matriks jarak alternatif dari daerah perkiraan perbatasan (Q)
        $matriksJarak = [];
        foreach ($matriksTertimbang as $jenisPengaduanId => $nilai) {
            foreach ($nilai as $kriteriaId => $v) {
                $matriksJarak[$jenisPengaduanId][$kriteriaId] = $v - $matriksPerkiraan[$kriteriaId];
            }
        }

        // Debug: Log matriks jarak alternatif
        Log::info('Matriks Jarak Alternatif: ', $matriksJarak);

        // Penentuan nilai Q dan perankingan
        $hasilAkhir = [];
        foreach ($matriksJarak as $jenisPengaduanId => $nilai) {
            $hasilAkhir[$jenisPengaduanId] = array_sum($nilai);
        }
        arsort($hasilAkhir); // Urutkan hasil akhir dari yang tertinggi ke terendah

        // Debug: Log hasil akhir
        Log::info('Hasil Akhir MABAC: ', $hasilAkhir);

        return view('admin.prioritas.mabac', compact('hasilAkhir'));
    }
}



