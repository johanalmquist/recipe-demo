<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Recipe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search($q)
    {
        $result = Recipe::where('name', 'like', $q.'%')->get();
        if($result->count() === 0) {
            return response(null, 204);
        }
        return $result;
    }
}
