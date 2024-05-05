<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JPengaduanModel extends Model
{
    use HasFactory;
    protected $table = "jenis_pengaduan";
    protected $primaryKey = "id_jenis_pengaduan";
    protected $fillable = ['pengaduan_kode', 'pengaduan_nama','created_at','update_at'];

    public function jPengaduan(): HasMany
    {
        return $this->hasMany(PengaduanModel::class);
    }
    
}
