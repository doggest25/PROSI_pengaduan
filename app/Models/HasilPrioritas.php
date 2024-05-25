<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPrioritas extends Model
{
    use HasFactory;
    protected $table = 'hasil_prioritas';

    protected $fillable = [
        'id_pengaduan',
        'final_score',
        
    ];
    public function pengaduan()
    {
        return $this->belongsTo(PengaduanModel::class, 'id_pengaduan', 'id_pengaduan');
    }
}
