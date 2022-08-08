<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
            "name",
            "email",
            "telp",
            "subject",
            "message",
            "created_at"
    ];
    
}
