<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [

//            PRODUCTS

            [//1
                'field_id' => 1,
                'parent_id' => null,
                'name' => 'PLC',
            ],
            [//2
                'field_id' => 1,
                'parent_id' => null,
                'name' => 'HMI',
            ],
            [//3
                'field_id' => 1,
                'parent_id' => null,
                'name' => 'PCB',
            ],
            [//4
                'field_id' => 1,
                'parent_id' => null,
                'name' => 'تابلو برق',
            ],
            [//5
                'field_id' => 1,
                'parent_id' => null,
                'name' => 'متفرقه',
            ],

//            PRODUCT-PLC subs
                [//6
                    'field_id' => 1,
                    'parent_id' => 1,
                    'name' => 'ریلی',
                ],
                [//7
                    'field_id' => 1,
                    'parent_id' => 1,
                    'name' => 'غیر ریلی',
                ],
//            PRODUCT-PLC subs
                [//8
                    'field_id' => 1,
                    'parent_id' => 2,
                    'name' => 'لمسی',
                ],
                [//9
                    'field_id' => 1,
                    'parent_id' => 2,
                    'name' => 'غیر لمسی',
                ],

//            SERVICES

            [//10
                'field_id' => 2,
                'parent_id' => null,
                'name' => 'پروژه',
            ],
            [//11
                'field_id' => 2,
                'parent_id' => null,
                'name' => 'نرم‌افزار',
            ],
            [//12
                'field_id' => 2,
                'parent_id' => null,
                'name' => 'سخت‌افزار',
            ],
            [//13
                'field_id' => 2,
                'parent_id' => null,
                'name' => 'صنایع مرتبط',
            ],

//            SERVICE-Project subs
                [//14
                    'field_id' => 2,
                    'parent_id' => 10,
                    'name' => 'مشاوره،نظارت،طراحی و کنترل',
                ],
                [//15
                    'field_id' => 2,
                    'parent_id' => 10,
                    'name' => 'نصب و راه‌اندازی',
                ],
//                SERVICE-Software subs
                [//16
                    'field_id' => 2,
                    'parent_id' => 11,
                    'name' => 'برنامه‌نویسی میکروکنترلر و PLC',
                ],
                [//17
                    'field_id' => 2,
                    'parent_id' => 11,
                    'name' => 'طراحی رابط گرافیکی و HMI',
                ],
                [//18
                    'field_id' => 2,
                    'parent_id' => 11,
                    'name' => 'مانیتورینگ هوشمند صنعتی و ساختمانی',
                ],

//                SERVICE-Hardware subs
                [//19
                    'field_id' => 2,
                    'parent_id' => 12,
                    'name' => 'بردهای الکترونیکی و ترانسمیتر',
                ],
                [//20
                    'field_id' => 2,
                    'parent_id' => 12,
                    'name' => 'تابلو برق و کنترل پنل',
                ],

//            Service-Related Industries subs
                [//21
                    'field_id' => 2,
                    'parent_id' => 13,
                    'name' => 'برودتی و حرارتی',
                ],
                [//22
                    'field_id' => 2,
                    'parent_id' => 13,
                    'name' => 'زراعی و باغی',
                ],
                [//23
                    'field_id' => 2,
                    'parent_id' => 13,
                    'name' => 'دام، طیور و آبزیان',
                ],
                [//24
                    'field_id' => 2,
                    'parent_id' => 13,
                    'name' => 'تولید و بسته‌بسته‌بندی',
                ],

//            ARTICLES

            [//25
                'field_id' => 3,
                'parent_id' => null,
                'name' => 'نرم‌افزار',
            ],
            [//26
                'field_id' => 3,
                'parent_id' => null,
                'name' => 'سخت‌افزار',
            ],
            [//27
                'field_id' => 3,
                'parent_id' => null,
                'name' => 'صنایع مرتبط',
            ],

//                SERVICE-Software subs
                [//28
                    'field_id' => 3,
                    'parent_id' => 25,
                    'name' => 'برنامه‌نویسی میکروکنترلر و PLC',
                ],
                [//29
                    'field_id' => 3,
                    'parent_id' => 25,
                    'name' => 'طراحی رابط گرافیکی و HMI',
                ],
                [//30
                    'field_id' => 3,
                    'parent_id' => 25,
                    'name' => 'مانیتورینگ هوشمند صنعتی و ساختمانی',
                ],

//                SERVICE-Hardware subs
                [//31
                    'field_id' => 3,
                    'parent_id' => 26,
                    'name' => 'بردهای الکترونیکی و ترانسمیتر',
                ],
                [//32
                    'field_id' => 3,
                    'parent_id' => 26,
                    'name' => 'تابلو برق و کنترل پنل',
                ],

//            Service-Related Industries subs
                [//33
                    'field_id' => 3,
                    'parent_id' => 27,
                    'name' => 'برودتی و حرارتی',
                ],
                [//34
                    'field_id' => 3,
                    'parent_id' => 27,
                    'name' => 'زراعی و باغی',
                ],
                [//35
                    'field_id' => 3,
                    'parent_id' => 27,
                    'name' => 'دام، طیور و آبزیان',
                ],
                [//36
                    'field_id' => 3,
                    'parent_id' => 27,
                    'name' => 'تولید و بسته‌بسته‌بندی',
                ],
        ];

        Category::insert($categories);
    }
}
