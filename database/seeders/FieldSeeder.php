<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Field;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Field::create([
            'name'=>'مقالات',
            'route' => 'articles',
            'show_menu' => true
        ]);

        Field::create([
            'name'=>'خدمات',
            'route' => 'services',
            'show_menu' => true
        ]);

        Field::create([
            'name'=>'محصولات',
            'route' => 'products',
            'show_menu' => true
        ]);
    }
}
