<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testimonials = [
            [
                'name' => 'PRIYA S.',
                'phone_number' => '9876543210',
                'feedback' => 'Absolutely amazing fit and the material is super soft. Will definitely buy again!',
                'status' => 'accept',
                'rate' => 5,
            ],
            [
                'name' => 'JEYANTHI RK',
                'phone_number' => '9876543211',
                'feedback' => 'Very good fabric and reasonable price. I am very satisfied to purchase.',
                'status' => 'accept',
                'rate' => 5,
            ],
            [
                'name' => 'CSJ DEEPA',
                'phone_number' => '9876543212',
                'feedback' => 'Very reasonable price, nice collections also. Jeni sister also very patience with the customers.',
                'status' => 'accept',
                'rate' => 5,
            ],
            [
                'name' => 'ANJALI SHARMA',
                'phone_number' => '9876543213',
                'feedback' => 'The fabric is incredibly soft and comfortable. Highly recommended!',
                'status' => 'accept',
                'rate' => 5,
            ]
        ];

        foreach ($testimonials as $testimonial) {
            DB::table('client_feedback')->insert($testimonial);
        }
    }
}
