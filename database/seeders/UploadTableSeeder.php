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

        // Upload::create([
        //     'folder_name' => 'parent',
        //     'type' => 'folder',
        //     'file_original_name' => null,
        //     'file_name' => null,
        //     'user_id' => null,
        //     'extension' => null,
        //     'file_size' => null
        // ]);

        // Upload::create([
        //     'folder_id' => 1,
        //     'file_original_name' => 'balubaid',
        //     'file_name' => 'uploads/vendors/balubaid.jpeg',
        //     'user_id' => 1,
        //     'extension' => 'jpeg',
        //     'type' => 'image',
        //     'file_size' => '28070'
        // ]);

        // Upload::create([
        //     'folder_id' => 1,
        //     'file_original_name' => 'almunajem',
        //     'file_name' => 'uploads/vendors/almunajem.webp',
        //     'user_id' => 1,
        //     'extension' => 'webp',
        //     'type' => 'image',
        //     'file_size' => '28070'
        // ]);

        // Upload::create([
        //     'folder_id' => 1,
        //     'file_original_name' => 'bindawood',
        //     'file_name' => 'uploads/vendors/bindawood.jpeg',
        //     'user_id' => 1,
        //     'extension' => 'jpeg',
        //     'type' => 'image',
        //     'file_size' => '28070'
        // ]);

        // Upload::create([
        //     'folder_id' => 1,
        //     'file_original_name' => 'binzagr',
        //     'file_name' => 'uploads/vendors/binzagr.webp',
        //     'user_id' => 1,
        //     'extension' => 'webp',
        //     'type' => 'image',
        //     'file_size' => '28070'
        // ]);

        // Upload::create([
        //     'folder_id' => 1,
        //     'file_original_name' => 'placeholder',
        //     'file_name' => 'assets/img/placeholder.jpg',
        //     'user_id' => 1,
        //     'extension' => 'jpg',
        //     'type' => 'image',
        //     'file_size' => '28070'
        // ]);

        // Upload::create([
        //     'folder_id' => 1,
        //     'file_original_name' => 'White Logo',
        //     'file_name' => 'assets/img/logo-white.png',
        //     'user_id' => 1,
        //     'extension' => 'png',
        //     'type' => 'image',
        //     'file_size' => '28070'
        // ]);

        // Upload::create([
        //     'folder_id' => 1,
        //     'file_original_name' => 'Logo',
        //     'file_name' => 'assets/img/logo.png',
        //     'user_id' => 1,
        //     'extension' => 'png',
        //     'type' => 'image',
        //     'file_size' => '28070'
        // ]);

        // Upload::create([
        //     'folder_id' => 1,
        //     'file_original_name' => 'Favicon Logo',
        //     'file_name' => 'assets/img/favicon.png',
        //     'user_id' => 1,
        //     'extension' => 'png',
        //     'type' => 'image',
        //     'file_size' => '28070'
        // ]);
        // Upload::create([
        //     'folder_id' => 1,
        //     'file_original_name' => 'icon-placeholder',
        //     'file_name' => '/assets/img/icon-placeholder.jpeg',
        //     'user_id' => 1,
        //     'extension' => 'jpeg',
        //     'type' => 'image',
        //     'file_size' => '28070'
        // ]);
        // Upload::create([
        //     'folder_id' => 1,
        //     'file_original_name' => 'icon-placeholder',
        //     'file_name' => '/assets/img/banner-placeholder.png',
        //     'user_id' => 1,
        //     'extension' => 'png',
        //     'type' => 'image',
        //     'file_size' => '28070'
        // ]);

        $path = base_path() . '/database/seeders/data/Upload.json';
        $uploads = json_decode(file_get_contents($path), true);
        foreach ($uploads['uploads'] as $upload) {
            Upload::create($upload);
        }
    }
}
