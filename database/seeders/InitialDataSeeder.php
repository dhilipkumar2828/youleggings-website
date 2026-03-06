<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Clear tables
        DB::table('about')->truncate();
        DB::table('banners')->truncate();
        DB::table('categories')->truncate();
        DB::table('products')->truncate();
        DB::table('product_variants')->truncate();
        DB::table('client_feedback')->truncate();
        DB::table('taxes')->truncate();

        // 2. Default Tax
        $taxId = DB::table('taxes')->insertGetId([
            'tax_name' => 'GST 12%',
            'percentage' => 12,
            'percentage1' => 12,
            'status' => 'active',
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. About Section
        DB::table('about')->insert([
            'title' => 'Comfort Without Compromise',
            'slug' => 'about-us',
            'name' => 'You Leggings',
            'description' => '<p>At You Leggings, we believe every woman deserves comfort without compromise. Born from the legacy of TANTEX, we bring you premium quality with zero compromise on fit and fabric. Our leggings are designed to move with you, providing effortless style and day-long softness for every occasion.</p>',
            'photo' => '_DSC8682-Edit.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Banners
        DB::table('banners')->insert([
            [
                'title' => 'Experience True Comfort',
                'photo' => 'LEGGINGS.mp4',
                'mobile_photo' => 'LEGGINGS.mp4',
                'link' => '#shop',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Luxury Made Affordable',
                'photo' => '_DSC8723-Edit.jpg',
                'mobile_photo' => '_DSC8723-Edit.jpg',
                'link' => '#shop',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 4. Categories
        $catIds = [];
        $cats = [
            ['title' => 'Full Length', 'photo' => '_DSC7786-Edit.jpg'],
            ['title' => 'Ankle Length', 'photo' => '_DSC8065-Edit.jpg'],
            ['title' => 'Kids Collection', 'photo' => '_DSC8489-Edit.jpg'],
            ['title' => 'Printed Gallery', 'photo' => '_DSC8832.jpg'],
        ];
        foreach ($cats as $index => $cat) {
            $catIds[] = DB::table('categories')->insertGetId([
                'title' => $cat['title'],
                'slug' => Str::slug($cat['title']),
                'photo' => $cat['photo'],
                'status' => 'active',
                'home' => 'active',
                'homeorder' => $index + 1,
                'is_parent' => 0,
                'parent_id' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. Products & Variants
        $productItems = [
            ['name' => 'Nude Comfort Ankle', 'img' => '_DSC8510-Edit.jpg'],
            ['name' => 'Cobalt Core Legging', 'img' => '_DSC8533-Edit.jpg'],
            ['name' => 'Aqua Flex Active', 'img' => '_DSC8541-Edit.jpg'],
            ['name' => 'Neon Move Set', 'img' => '_DSC8587-Edit.jpg'],
            ['name' => 'Scarlet Sport Fit', 'img' => '_DSC8752-Edit.jpg'],
            ['name' => 'Floral Blush Pair', 'img' => '_DSC8785-Edit.jpg'],
            ['name' => 'Olive Essential', 'img' => '_DSC8789-Edit.jpg'],
            ['name' => 'Mint Aura Kurti', 'img' => '_DSC8910.jpg'],
        ];

        foreach ($productItems as $index => $item) {
            $catId = $catIds[$index % count($catIds)];
            $id = DB::table('products')->insertGetId([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'category' => (string)$catId,
                'status' => 'active',
                'description' => 'Premium luxury leggings for all-day wear.',
                'stock' => 100,
                'regular_price' => rand(499, 1299),
                'discount' => rand(5, 15),
                'discount_type' => 'percent',
                'tax_id' => $taxId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('product_variants')->insert([
                'product_id' => $id,
                'sku' => 'YL-' . Str::upper(Str::random(6)),
                'variants' => 'Standard',
                'photo' => $item['img'],
                'regular_price' => rand(499, 1299),
                'in_stock' => 50,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 6. Client Feedback
        DB::table('client_feedback')->insert([
            ['name' => 'Jeyanthi RK', 'phone_number' => '9876543210', 'feedback' => 'Very good fabric and reasonable price. I am very satisfied to purchase.', 'rate' => 5, 'status' => 'accept', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Anita R.', 'phone_number' => '9876543211', 'feedback' => 'Great quality for the price! Really love the fit and how soft it feels.', 'rate' => 4, 'status' => 'accept', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Meera S.', 'phone_number' => '9876543212', 'feedback' => 'I\'ve washed them five times already and the color hasn\'t faded.', 'rate' => 5, 'status' => 'accept', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
