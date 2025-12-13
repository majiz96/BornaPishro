<?php

namespace Database\Seeders;

use App\Models\Information;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Information::create([
            'phone' => '2166729171+',
            'mobile' => '9124442958+',
            'email' => 'm.azizpour2015@gmail.com',
            'address' => 'تهران ، خ انقلاب اسلامی ، نرسیده به خ لاله زار شمالی ، پ 00',
            'activity' => 'شنبه تا چهارشنبه از ساعت ۱۰ صبح تا ۵ بعد از ظهر',
            'response' => 'شنبه تا چهارشنبه از ساعت ۱۱ صبح تا ۳ بعد از ظهر',
            'start_date' => '1405/01/15',
            'about_us' => 'اعضای گروه مهندسی برنا پیشرو تحصیل کرده در رشته های برق و مکانیک هستند
و هر یک سالها به کسب تجربه در صنعت برق و مکانیک در شرکتهای مختلف معتبر در
کشور پرداخته اند و بخوبی نسبت به پروژه های صنعتی در این حوزه و اتوماسیون صنعتی شناخت دارند.
علی رغم تلاش مسولین در بهبود اوضاع صنعت ،اتصال علم و دانشگاه به صنعت همواره
یکی از حوزه های مغفول در کشور ما بوده .                            ',
        ]);
    }
}
