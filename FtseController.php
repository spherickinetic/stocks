<?php

namespace App\Http\Controllers;

use App\ftse;
use Illuminate\Http\Request;

class FtseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ftsePrices = ftse::all();
        return view('ftse/index')->with(['ftsePrices' => $ftsePrices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach($ftsePrices as $ftsePrice){
            $price = new ftse();
            $price -> timePoint = $ftsePrice -> timePoint;
            $price -> bidPrice = $ftsePrice -> bidPrice;
            $price -> offerPrice = $ftsePrice -> offerPrice;
            $price -> save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ftse  $ftse
     * @return \Illuminate\Http\Response
     */
    public function show(ftse $ftse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ftse  $ftse
     * @return \Illuminate\Http\Response
     */
    public function edit(ftse $ftse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ftse  $ftse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ftse $ftse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ftse  $ftse
     * @return \Illuminate\Http\Response
     */
    public function destroy(ftse $ftse)
    {
        //
    }
}
