<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title', 'body', 'size', 'productType', 'color', 'price'];

    public static function orders()
    {
        return $this->belongsToMany('App\Order', 'order_products')
    	->withPivot('quantity')
    	->withTimestamps();
    }
}
