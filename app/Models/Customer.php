<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        "name",
        "address",
        "phone",
        "email",
    ];

    public function invoices(){
        return $this->hasMany('App\Models\Invoice','id_customer');
    }
}
