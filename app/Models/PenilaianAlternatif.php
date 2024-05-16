<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianAlternatif extends Model
{
    use HasFactory;

    protected $table = 'penilaian_alternatif';

    protected $fillable = [
        'id_jenis_pengaduan',
        'kriteria_id',
        'nilai',
    ];

    public function jenisPengaduan()
    {
        return $this->belongsTo(JPengaduanModel::class, 'id_jenis_pengaduan');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
