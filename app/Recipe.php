<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['name', 'slug', 'desctiption', 'how_to' , 'duration'];

    public function ingredient()
    {
        return $this->hasMany(Ingredient::class);
    }
}
