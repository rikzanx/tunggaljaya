<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'jenis',
        'ukuran',
        'koneksi',
        'material',
        'brand',
        'jumlah',
        'keterangan',
    ];
}
