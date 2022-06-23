<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            [
                'id' => 1,
                'name' => 'balubaid',
                'cr_no' => '11111111',
                'vat_no' => '11111111',
                'email' => 'balubaid@info.com',
                'phone' => '1111111111',
                'contact_user' => 'balubaid ali',
                'description' => 'descriptiondescriptiondescriptiondescription',
                'content' => 'contentcontentcontentcontent',
                'logo' => 1,
                'status' => 1
            ],
            [
                'id' => 2,
                'name' => 'almunajem',
                'cr_no' => '222222222',
                'vat_no' => '222222222',
                'email' => 'almunajem@info.com',
                'phone' => '222222222',
                'contact_user' => 'almunajem ali',
                'description' => 'descriptiondescriptiondescriptiondescription',
                'content' => 'contentcontentcontentcontent',
                'logo' => 2,
                'status' => 1
            ],
            [
                'id' => 3,
                'name' => 'bindawood',
                'cr_no' => '333333333',
                'vat_no' => '333333333',
                'email' => 'bindawood@info.com',
                'phone' => '333333333',
                'contact_user' => 'bindawood ali',
                'description' => 'descriptiondescriptiondescriptiondescription',
                'content' => 'contentcontentcontentcontent',
                'logo' => 3,
                'status' => 1
            ],
            [
                'id' => 4,
                'name' => 'binzagr',
                'cr_no' => '444444444',
                'vat_no' => '444444444',
                'email' => 'binzagr@info.com',
                'phone' => '444444444',
                'contact_user' => 'binzagr ali',
                'description' => 'descriptiondescriptiondescriptiondescription',
                'content' => 'contentcontentcontentcontent',
                'logo' => 4,
                'status' => 1
            ],
        ];

        Supplier::insert($suppliers);
    }
}
