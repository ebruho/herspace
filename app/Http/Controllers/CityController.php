<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function search(Request $request)
    {
        $query = trim((string) $request->get('q', ''));
        if ($query === '') {
            return response()->json([]);
        }

        $driver = City::query()->getConnection()->getDriverName();

        $cities = City::query()
            ->with('country')
            ->when(
                $driver === 'pgsql',
                fn ($q) => $q->where('name', 'ILIKE', '%'.$query.'%'),
                fn ($q) => $q->whereRaw('LOWER(name) LIKE ?', ['%'.mb_strtolower($query).'%'])
            )
            ->limit(10)
            ->get();

        return $cities->map(function (City $city) {
            $countryName = $city->country?->name ?? '';

            return [
                'id' => $city->id,
                'text' => trim($city->name.', '.$countryName, ', '),
            ];
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
    }
}
