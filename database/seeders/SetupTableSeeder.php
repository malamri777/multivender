<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Country;
use App\Models\Currency;
use App\Models\District;
use App\Models\State;
use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Translations\Entities\CountryStateTranslation;
use Modules\Translations\Entities\CountryTranslation;
use Modules\Translations\Entities\DistrictTranslation;

class SetupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Tax
        Tax::create([
            'name' => 'VAT',
            'tax_status' => true
        ]);


        // Currency
        Currency::create([
            'name' => 'Saudi Riyals',
            'symbol' => 'SAR',
            'exchange_rate' => '1',
            'status' => 1,
            'code' => 'SAR',
        ]);

        Currency::create([
            'name' => 'U.S. Dollar',
            'symbol' => '$',
            'exchange_rate' => '0.75',
            'status' => 1,
            'code' => 'USD',
        ]);

        // Country
        Country::create([
            'code' => 'SA',
            'name' => 'Saudi Arabia'
        ]);
        CountryTranslation::create([
            'country_id' => 1,
            'name' => 'المملكة العربية السعودية',
            'lang' => 'sa'
        ]);

        // State
        State::create([
            'name' => 'Riyadh Region',
            'country_id' => 1,
            'status' => 1,
        ]);
        CountryStateTranslation::create([
            'state_id' => 1,
            'name' => 'الرياض',
            'lang' => 'sa'
        ]);

        State::create([
            'name' => 'Eastern Region',
            'country_id' => 1,
            'status' => 1,
        ]);
        CountryStateTranslation::create([
            'state_id' => 2,
            'name' => 'الشرقية',
            'lang' => 'sa'
        ]);

        State::create([
            'name' => 'Mecca Region',
            'country_id' => 1,
            'status' => 1,
        ]);
        CountryStateTranslation::create([
            'state_id' => 3,
            'name' => 'مكه المكرمة',
            'lang' => 'sa'
        ]);

        // City
        City::create([
            'name' => 'Riyadh',
            'state_id' => 1,
            'status' => 1
        ]);
        CityTranslation::create([
            'city_id' => 1,
            'name' => 'الرياض',
            'lang' => 'sa'
        ]);

        City::create([
            'name' => 'Dammam',
            'state_id' => 2,
            'status' => 1
        ]);
        CityTranslation::create([
            'city_id' => 3,
            'name' => 'الدمام',
            'lang' => 'sa'
        ]);

        City::create([
            'name' => 'Jeddah',
            'state_id' => 3,
            'status' => 1
        ]);
        CityTranslation::create([
            'city_id' => 3,
            'name' => 'جده',
            'lang' => 'sa'
        ]);

        // District
        $district = District::create([
           'name' => 'Alrodah',
            'city_id' => 1,
        ]);
        DistrictTranslation::create([
            'district_id' => $district->id,
            'name' => 'الروضة',
            'lang' => 'sa'
        ]);

        $district = District::create([
            'name' => 'Alyarmok',
            'city_id' => 1,
        ]);
        DistrictTranslation::create([
            'district_id' => $district->id,
            'name' => 'اليرموك',
            'lang' => 'sa'
        ]);

        $district = District::create([
            'name' => 'Almalga',
            'city_id' => 1,
        ]);
        DistrictTranslation::create([
            'district_id' => $district->id,
            'name' => 'الملقا',
            'lang' => 'sa'
        ]);

        $district = District::create([
            'name' => 'Almalga',
            'city_id' => 2,
        ]);
        DistrictTranslation::create([
            'district_id' => $district->id,
            'name' => 'الملقا',
            'lang' => 'sa'
        ]);
    }
}
