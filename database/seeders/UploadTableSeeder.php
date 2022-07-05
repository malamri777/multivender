<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\Upload;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UploadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $uploads = [
            [
                'id' => 1,
                'file_original_name' => 'balubaid',
                'file_name' => 'assets/img/vendors/balubaid.jpeg',
                'user_id' => 1,
                'extension' => 'jpeg',
                'type' => 'image',
                'file_size' => '28070',
                'uploadable_id' => 1,
                'uploadable_type' => Supplier::class,
                'kind' => 'logo'
            ],
            [
                'id' => 2,
                'file_original_name' => 'almunajem',
                'file_name' => 'assets/img/vendors/almunajem.webp',
                'user_id' => 1,
                'extension' => 'webp',
                'type' => 'image',
                'file_size' => '28070',
                'uploadable_id' => 2,
                'uploadable_type' => Supplier::class,
                'kind' => 'logo'
            ],
            [
                'id' => 3,
                'file_original_name' => 'bindawood',
                'file_name' => 'assets/img/vendors/bindawood.jpeg',
                'user_id' => 1,
                'extension' => 'jpeg',
                'type' => 'image',
                'file_size' => '28070',
                'uploadable_id' => 3,
                'uploadable_type' => Supplier::class,
                'kind' => 'logo'
            ],
            [
                'id' => 4,
                'file_original_name' => 'binzagr',
                'file_name' => 'assets/img/vendors/binzagr.webp',
                'user_id' => 1,
                'extension' => 'webp',
                'type' => 'image',
                'file_size' => '28070',
                'uploadable_id' => 3,
                'uploadable_type' => Supplier::class,
                'kind' => 'logo'
            ],
            [
                'id' => 5,
                'file_original_name' => 'placeholder',
                'file_name' => 'assets/img/placeholder.jpg',
                'user_id' => 1,
                'extension' => 'jpg',
                'type' => 'image',
                'file_size' => '28070',
                'uploadable_id' => 4,
                'uploadable_type' => Supplier::class,
                'kind' => 'logo'
            ],
        ];

        Upload::insert($uploads);
    }
}
