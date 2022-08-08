<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagesProduct extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        "product_id",
        "image_product"
    ];

    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
