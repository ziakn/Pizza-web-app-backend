<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $fillable = [
        'user_id', 'category_id','title','description','model','point','sort', 'dimension','priceType',
        'price', 'meta_title', 'meta_description', 'meta_keyword', 'veg', 'status',
    ];
  
    
    public function category()
    {
       return $this->belongsTo('App\Category','category_id');
    }
    public function image()
    {
       return $this->hasMany('App\PizzaImage');
    }
    public function cuisine()
    {
       return $this->hasMany('App\PizzaCusine')->with('cuisine');
    }
    public function ingredient()
    {
       return $this->hasMany('App\PizzaIngredient')->with('ingredient');
    }
}
