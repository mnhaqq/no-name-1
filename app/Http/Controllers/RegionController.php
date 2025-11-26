<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Region::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'string|required',
            'capital' => 'string|required',
            'longitude' => 'string|required',
            'latitude' => 'string|required'
        ]);

        $region = Region::create($fields);

        return response()->json($region);
    }

    /**
     * Display the specified resource.
     */
    public function show(Region $region)
    {
        return response()->json($region);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Region $region)
    {
        $fields = $request->validate([
            'name' => 'string',
            'capital' => 'string',
            'longitude' => 'string',
            'latitude' => 'string'
        ]);

        $region->update($fields);

        return response()->json($region);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
        $region->delete();

        return response()->json(['message' => 'Region deleted successfully']);
    }
}
