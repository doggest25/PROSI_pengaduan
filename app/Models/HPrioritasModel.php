<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HPrioritasModel extends Model
{
    use HasFactory;

    protected $table = 'hasil_prioritas';

    protected $fillable = [
        'id_jenis_pengaduan',
        'score',
    ];
    
}
