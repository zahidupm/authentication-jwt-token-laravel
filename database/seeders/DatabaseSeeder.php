<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'firstName' => 'Zahid',
             'lastName' => 'Hasan',
             'email' => 'admin@inventory.com',
             'password' => bcrypt('123456'),
         ]);
    }
}
