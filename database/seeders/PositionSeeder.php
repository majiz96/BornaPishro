<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::create([
            'title' => 'مدیر',
            'description' => 'دسترسی کامل',
            'level'    => 3
        ]);

        Position::create([
            'title' => 'اپراتور',
            'description' => 'رسیدگی به شکایات و نظارت بر کامنتها',
            'level'    => 1
        ]);

        Position::create([
            'title' => 'ادمین',
            'description' => 'مدیریت مقالات و محصولات ',
            'level'    => 2
        ]);


        Position::create(
            [
                'title' => 'کاربر',
                'description' => 'کاربر ساده بدون دسترسی به صفحات مدیریتی',
                'level'    => 0
            ]);

    }
    }
