<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianAlternatif extends Model
{
    use HasFactory;

    protected $table = 'nilai_alternatif';

    protected $fillable = [
        'id_pengaduan',
        'kriteria_id',
        'nilai',
    ];

    public function nilaiAlternatif()
{
    return $this->hasMany(PenilaianAlternatif::class, 'id_pengaduan');
}

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
