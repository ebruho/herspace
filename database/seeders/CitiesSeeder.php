<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    public function run(): void
    {
        // Четем JSON файла
        $json = file_get_contents(storage_path('app/countries+cities.json'));

        // JSON -> PHP array
        $data = json_decode($json, true);

        // Минаваме през всички държави в JSON файла
        foreach ($data as $countryData) {

            // Създаваме държавата (ако не съществува)
            $country = Country::firstOrCreate([
                'name' => $countryData['name']
            ]);

            // Минаваме през градовете
            foreach ($countryData['cities'] as $cityName) {

                City::firstOrCreate([
                    'name' => $cityName,
                    'country_id' => $country->id,
                ]);
            }
        }
    }
}
