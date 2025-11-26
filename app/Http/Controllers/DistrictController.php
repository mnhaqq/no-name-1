<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class DistrictController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of districts.
     */
    public function indexByRegion(Region $region)
    {
        return response()->json($region->districts);
    }

    /**
     * Store a newly created district.
     */
    public function store(Request $request, Region $region)
    {
        // Ensure the authenticated user owns the region
        Gate::authorize('modify', $region);

        // Validate only the district name
        $fields = $request->validate([
            'district_name' => 'required|string',
        ]);

        // Create district through the relationship
        $district = $region->districts()->create($fields);

        return response()->json($district);
    }

    /**
     * Display a specific district.
     */
    public function show(District $district)
    {
        return response()->json($district);
    }

    /**
     * Update an existing district.
     */
    public function update(Request $request, District $district)
    {
        Gate::authorize('modify', $district);

        $fields = $request->validate([
            'district_name' => 'string'
        ]);

        $district->update($fields);

        return response()->json($district);
    }

    /**
     * Remove the specified district.
     */
    public function destroy(District $district)
    {
        Gate::authorize('modify', $district);

        $district->delete();

        return response()->json(['message' => 'District deleted successfully']);
    }
}
