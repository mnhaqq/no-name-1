<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class RegionController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

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

        $region = $request->user()->regions()->create($fields);

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
        Gate::authorize('modify', $region);

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
        Gate::authorize('modify', $region);
        
        $region->delete();

        return response()->json(['message' => 'Region deleted successfully']);
    }
}
