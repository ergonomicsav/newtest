<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'id'];

    public function  characteristics()
    {
        return $this->belongsToMany(Characteristic::class);
    }

}
