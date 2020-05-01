<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzaIngredient extends Model
{
    protected $fillable = [
        'pizza_id', 'ingredient_id'
    ];    
    public function ingredient()
    {
       return $this->belongsTo('App\Ingredient');
    }
}
