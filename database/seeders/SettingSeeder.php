<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'history' => 'This is the history of the company',
            'image' => 'default.jpg',
            'community_bio' => 'This is the community of the company',
            'community_structure' => 'This is the community structure of the company',
            'video1' => 'https://www.youtube.com/embed/your-video1',
            'video2' => 'https://www.youtube.com/embed/your-video2',
            'video' => 'https://www.youtube.com/embed/your-video3',
            'slogan' => 'This is the slogan of the company',
            'community_name' => 'This is the company name',
            'sender' => '6282128078893',
            'endpoint' => 'https://wag.cigs.web.id/send-message',
            'api_key' => 'ZMNgdCuH1Vi0OCQ6Recg8ZB9UPy68B',
        ]);
    }
}
