<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzaCusine extends Model
{
    protected $fillable = [
        'pizza_id', 'cuisine_id'
    ];    
    public function cuisine()
    {
       return $this->belongsTo('App\Cuisine');
    }
}
