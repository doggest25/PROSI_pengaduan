<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    use HasFactory;
    protected $table = 'contact_forms';
    protected $primaryKey = "id_pesan";
    protected $fillable = [
        'name',
        'email',
        'message',
    ];
}
