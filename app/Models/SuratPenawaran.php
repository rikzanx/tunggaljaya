<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPenawaran extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
            "id_pnw",
            "no_surat",
            "duedate",
            "name_customer",
            "address_customer",
            "phone_customer",
            "comment",
            "created_at"
    ];

    public function items(){
        return $this->hasMany('App\Models\SuratPenawaranItem','suratpenawaran_id');
    }
}