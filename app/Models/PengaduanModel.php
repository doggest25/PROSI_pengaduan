<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengaduanModel extends Model
{
    use HasFactory;
    protected $table = "v_pengaduan";
    protected $primaryKey = "id_pengaduan";
    protected $fillable = ['id_pengaduan','user_id','id_jenis_pengaduan', 'deskripsi','lokasi', 'bukti_foto','id_status_pengaduan','created_at','update_at'];

    public function users(): BelongsTo {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
    public function jenis_pengaduan(): BelongsTo {
        return $this->belongsTo(JPengaduanModel::class, 'id_jenis_pengaduan', 'id_jenis_pengaduan');
    }
    public function status_pengaduan(): BelongsTo {
        return $this->belongsTo(StatusPengaduanModel::class, 'id_status_pengaduan', 'id_status_pengaduan');
    }

   

    
}
