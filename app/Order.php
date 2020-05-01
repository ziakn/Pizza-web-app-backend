<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name','total','address','ip','status'
    ];
    public function pizza()
    {
       return $this->hasMany('App\OrderPizza')->with('pizza');
    } 
}
