<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contact;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin1',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('Admin123.'), 
            'phone' => '08123456789',
            'role' => 'admin'
        ]);

        
        Contact::create([
            'position'    => 'Manager',
            'name'        => 'Brian',
            'phone'       => '08123456789',
            'email'       => 'brian@seacatering.com',
            'open_hours'  => 'Monday - Saturday, 08.00 - 17.00 WIB',
            'address'   => 'https://www.google.com/maps?q=jakarta+indonesia&output=embed'
        ]);
    }
}
