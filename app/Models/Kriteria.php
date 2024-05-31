<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $table = "kriteria";
    protected $primaryKey = "id";
    protected $fillable = ['nama','jenis'];

    public function subKriteria()
    {
        return $this->hasMany(SubKriteria::class, 'kriteria_id');
    }

}
