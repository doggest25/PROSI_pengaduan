<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;


class UserModel extends Model implements AuthenticatableContract
{
    use HasFactory;

    use Authenticatable;
    protected $table = 'v_user';
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     * 
     * @var string
     */
    // protected $fillable = ['level_id', 'username', 'nama', 'password'];
    protected $fillable = ['level_id', 'username', 'nama', 'password', 'ktp', 'alamat', 'telepon', 'created_at','update_at'];

    
    public function hasAnyRole(...$roles)
{
    return $this->level->whereIn('level_nama', $roles)->exists();
}
    public function level(): BelongsTo {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
    
    public function pengaduan(): HasMany
    {
        return $this->hasMany(PengaduanModel::class);
    }

}