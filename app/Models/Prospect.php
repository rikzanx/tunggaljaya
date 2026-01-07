<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        "name",
        "address",
        "phone",
        "email",
        "status",
    ];
}
