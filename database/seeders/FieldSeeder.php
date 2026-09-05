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
            'model'=>'App\Models\Article',
            'route' => 'articles',
            'order' => 3,
            'show_menu' => true
        ]);

        Field::create([
            'name'=>'خدمات',
            'model'=>'App\Models\Service',
            'route' => 'services',
            'order' => 2,
            'show_menu' => true
        ]);

        Field::create([
            'name'=>'محصولات',
            'model'=>'App\Models\Product',
            'route' => 'products',
            'order' => 1,
            'show_menu' => true
        ]);
    }
}
