<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['status', 'country'];
 
    public function products()
    {
        return $this->belongsToMany('App\Product', 'order_products')
    	->withPivot('quantity')
    	->withTimestamps();
    }
}
