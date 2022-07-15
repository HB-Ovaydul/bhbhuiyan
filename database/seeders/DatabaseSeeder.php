<?php

namespace Database\Seeders;

use App\Models\patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


            patient::create([
                'first_name'         => 'Ovaydul',
                'email'              => 'ovaydul@gmail.com',
                'mobile'             => '01726144752',
                'password'           => 'hbhbhb',
            ]);

            patient::create([
                'first_name'         => 'bhuiyan',
                'email'              => 'bhuiyan@gmail.com',
                'mobile'             => '01726144756',
                'password'           => 'hnhnhn',
            ]);
            

    }
}
