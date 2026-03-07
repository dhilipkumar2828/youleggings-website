<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::updateOrCreate(
            ['slug' => 'contact-you-leggings'],
            [
                'title' => 'Get in Touch',
                'address' => '5/4, Surya Nagar, 2nd Street, Bridgeway Colony Extn, Tirupur - 641607',
                'email' => 'youleggings@gmail.com',
                'mobile' => '+91 740143 24967',
                'photo' => 'contact/contact-hero.jpg'
            ]
        );
    }
}
