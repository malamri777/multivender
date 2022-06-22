<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Translations\Entities\PageTranslation;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Page
        Page::create([
            'type' => 'home_page',
            'title' => 'Home Page',
            'content' => 'Home Page',
            'meta_title' => 'Home Page',
            'meta_description' => 'Home Page',
            'keywords' => 'Home Page',
        ]);
        PageTranslation::create([
            'page_id' => 1,
            'title' => 'الصفحة الرئيسة',
            'content' => 'الصفحة الرئيسة',
            'lang' => 'sa'
        ]);

        Page::create([
            'type' => 'seller_policy_page',
            'title' => 'Seller Policy Pages',
            'content' => 'Seller Policy Pages',
            'meta_title' => 'Seller Policy Pages',
            'meta_description' => 'Seller Policy Pages',
            'keywords' => 'Seller Policy Pages',
        ]);
        PageTranslation::create([
            'page_id' => 2,
            'title' => 'شروط والاحكام',
            'content' => 'شروط والاحكام',
            'lang' => 'sa'
        ]);

        Page::create([
            'type' => 'return_policy_page',
            'title' => 'Return Policy Page',
            'content' => 'Return Policy Page',
            'meta_title' => 'Return Policy Page',
            'meta_description' => 'Return Policy Page',
            'keywords' => 'Return Policy Page',
        ]);
        PageTranslation::create([
            'page_id' => 3,
            'title' => 'شروط الاسترجاع',
            'content' => 'شروط الاسترجاع',
            'lang' => 'sa'
        ]);

        Page::create([
            'type' => 'support_policy_page',
            'title' => 'Support Policy Page',
            'content' => 'Support Policy Page',
            'meta_title' => 'Support Policy Page',
            'meta_description' => 'Support Policy Page',
            'keywords' => 'Support Policy Page',
        ]);
        PageTranslation::create([
            'page_id' => 4,
            'title' => 'شروط الدعم الفني',
            'content' => 'شروط الدعم الفني',
            'lang' => 'sa'
        ]);

        Page::create([
            'type' => 'terms_conditions_page',
            'title' => 'Term Conditions Page',
            'content' => 'Term Conditions Page',
            'meta_title' => 'Term Conditions Page',
            'meta_description' => 'Term Conditions Page',
            'keywords' => 'Term Conditions Page',
        ]);
        PageTranslation::create([
            'page_id' => 5,
            'title' => 'شروط والاحكام',
            'content' => 'شروط والاحكام',
            'lang' => 'sa'
        ]);

        Page::create([
            'type' => 'privacy_policy_page',
            'title' => 'Privacy Policy Page',
            'content' => 'Privacy Policy Page',
            'meta_title' => 'Privacy Policy Page',
            'meta_description' => 'Privacy Policy Page',
            'keywords' => 'Privacy Policy Page',
        ]);
        PageTranslation::create([
            'page_id' => 6,
            'title' => 'شروط والاحكام',
            'content' => 'شروط والاحكام',
            'lang' => 'sa'
        ]);
    }
}
