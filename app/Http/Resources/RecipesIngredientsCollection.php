<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RecipesIngredientsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'ingredient' => new IngredientCollection($this->ingredient),
            'measurment_qty' => $this->measurmentQty->name,
            'measurment_unit' => $this->measurmentQnit->name,
            'recipe' => $this->recipe->name
        ];
    }
}
