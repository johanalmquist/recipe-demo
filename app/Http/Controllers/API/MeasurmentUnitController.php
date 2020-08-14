<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MeasurmentUnitCollection;
use App\Http\Resources\MeasurmentUnitResurce;
use App\MeasurmentUnit;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class MeasurmentUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new MeasurmentUnitCollection(MeasurmentUnit::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'short_name' => 'required'
        ]);
        MeasurmentUnit::create($request->all());
        return response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MeasurmentUnit  $measurmentUnit
     * @return \Illuminate\Http\Response
     */
    public function show(MeasurmentUnit $measurmentUnit)
    {
        return New MeasurmentUnitResurce($measurmentUnit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MeasurmentUnit  $measurmentUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MeasurmentUnit $measurmentUnit)
    {
        if($request->name){
            $measurmentUnit->name = $request->name;
        }
        if($request->short_name){
            $measurmentUnit->short_name = $request->short_name;
        }
        $measurmentUnit->save();

        return $measurmentUnit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MeasurmentUnit  $measurmentUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(MeasurmentUnit $measurmentUnit)
    {
        $measurmentUnit->delete();
        return null;
    }
}
