<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $sourceImagePath = public_path('setting_image/wayang.png');
        $destinationImagePath = 'setting_image/wayang.png';

        // Ensure directories exist
        if (!is_dir(public_path('images/'))) {
            mkdir(public_path('images/'), 0755, true);
        }

        if (!is_dir(public_path('setting_videos/'))) {
            mkdir(public_path('setting_videos/'), 0755, true);
        }

        File::copy($sourceImagePath, public_path($destinationImagePath));

        $settings = [
            [
                'history' => 'This is the history of the company',
                'community_bio' => 'This is the community of the company',
                'community_structure' => 'This is the community structure of the company',
                'video1' => 'video1.mp4',
                'video2' => 'video2.mp4',
                'video' => 'video.mp4',
                'slogan' => 'This is the slogan of the company',
                'community_name' => 'This is the company name',
                'sender' => '6282128078893',
                'endpoint' => 'https://wag.cigs.web.id/send-message',
                'api_key' => 'ZMNgdCuH1Vi0OCQ6Recg8ZB9UPy68B',
                'image' => $destinationImagePath,
            ],
        ];

        foreach ($settings as $settingData) {
            $imagePath = public_path('setting_image/wayang.png');

            $imageContents = file_get_contents($imagePath);
            $imagePathInStorage = 'setting_image/wayang.png';
            Storage::disk('public')->put($imagePathInStorage, $imageContents);

            $settingData['image'] = $imagePathInStorage;
            $settingData['video'] = 'setting_videos/' . $settingData['video'];
            $settingData['video1'] = 'setting_videos/' . $settingData['video1'];
            $settingData['video2'] = 'setting_videos/' . $settingData['video2'];
            DB::table('settings')->insert($settingData);
        }
    }
}
