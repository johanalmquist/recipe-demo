<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name', 'recipe_id', 'measurment_unit_id', 'amount'];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function measurment_unit()
    {
        return $this->belongsTo(MeasurmentUnit::class);
    }
}
