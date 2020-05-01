<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPizza extends Model
{
    protected $fillable = [
        'order_id', 'pizza_id',
    ];
    public function pizza()
    {
       return $this->belongsTo('App\Pizza','pizza_id')->with('image');
    } 
}
