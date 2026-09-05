<?php

namespace Database\Seeders;

use App\Models\Information;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PositionSeeder::class,
            UserSeeder::class,
            FieldSeeder::class,
            CategorySeeder::class,
            InformationSeeder::class,
        ]);
    }
}
