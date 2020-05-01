<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzaImage extends Model
{
    protected $fillable = [
        'pizza_id', 'name','src',
    ];
}
