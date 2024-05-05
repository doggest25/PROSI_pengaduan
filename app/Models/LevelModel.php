<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
    use HasFactory;
    protected $table = "v_level";
    protected $primaryKey = "level_id";
    protected $fillable = ['level_kode', 'level_nama'];

    public function users(): HasMany
    {
        return $this->hasMany(UserModel::class);
    }
}