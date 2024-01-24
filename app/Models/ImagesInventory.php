<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagesInventory extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        "inventory_id",
        "image_inventory"
    ];

    public function inventory(){
        return $this->hasOne('App\Models\Inventory','id','inventory_id');
    }
}