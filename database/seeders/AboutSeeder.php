<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::updateOrCreate(
            ['slug' => 'about-you-leggings'],
            [
                'title' => 'Comfort Without Compromise',
                'sub_title' => 'About You Leggings',
                'description' => 'Built on TANTEX Legacy, Designed for Every Woman',
                'photo' => 'about/DSC8682.jpg',
                'promise_title' => 'Everyday Comfort, Premium Feel',
                'promise_desc' => 'At You Legging, we believe every woman deserves comfort without compromise. Born from the trusted legacy of TANTEX, we create bottom wear that blends affordability with high-end quality. Our leggings are crafted with premium fabrics for a flattering fit, dependable stretch, and long-lasting durability that stays soft wash after wash. Whether you are at work, running errands, or relaxing at home, You Legging moves with you.',
                'why_choose_1_title' => 'From TANTEX Legacy',
                'why_choose_1_desc' => 'A trusted brand foundation with years of quality experience.',
                'why_choose_2_title' => 'Zero Compromise Quality',
                'why_choose_2_desc' => 'Premium fabrics, carefully tested for fit, comfort, and durability.',
                'why_choose_3_title' => 'Affordable Luxury',
                'why_choose_3_desc' => 'High-end feel at market-friendly prices for everyday wear.',
                'why_choose_4_title' => 'Everyday Versatility',
                'why_choose_4_desc' => 'Designed for work, play, travel, and everything in between.',
                'why_choose_5_title' => 'Wide Range of Choices',
                'why_choose_5_desc' => 'Colors, styles, and fits made for every woman.',
            ]
        );
    }
}
