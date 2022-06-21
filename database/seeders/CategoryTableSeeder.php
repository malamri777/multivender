<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Translations\Entities\CategoryTranslation;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Milks and Dairies'
        ]);
        CategoryTranslation::create([
            'category_id' => 1,
            'name' => 'الألبان',
            'lang' => 'sa'
        ]);

        Category::create([
            'name' => 'Baking material'
        ]);
        CategoryTranslation::create([
            'category_id' => 2,
            'name' => 'مواد الخبز',
            'lang' => 'sa'
        ]);

        Category::create([
            'name' => 'Fresh Fruit'
        ]);
        CategoryTranslation::create([
            'category_id' => 3,
            'name' => 'فاكهة طازجة',
            'lang' => 'sa'
        ]);

        Category::create([
            'name' => 'Fresh Seafood'
        ]);
        CategoryTranslation::create([
            'category_id' => 4,
            'name' => 'مأكولات بحرية طازجة',
            'lang' => 'sa'
        ]);
    }
}
