<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
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
        $fields = $request->validate([
            'district_name' => 'required|string',
        ]);

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
        $district->delete();

        return response()->json(['message' => 'District deleted successfully']);
    }
}
