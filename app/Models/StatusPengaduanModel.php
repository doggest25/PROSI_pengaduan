<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusPengaduanModel extends Model
{
    use HasFactory;
    protected $table = "status_pengaduan";
    protected $primaryKey = "id_status_pengaduan";
    protected $fillable = ['status_kode', 'status_nama'];

    public function detailPengaduan(): HasMany
    {
        return $this->hasMany(PengaduanModel::class);
    }

}
