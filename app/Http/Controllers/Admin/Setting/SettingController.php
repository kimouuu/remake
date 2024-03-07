<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SettingUpdateRequest;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.edit', compact('setting'));
    }

    public function update(SettingUpdateRequest $request, Setting $setting)
    {
        $validated = $request->validated();

        $setting->update([
            'history' => $validated['history'],
            'community_bio' => $validated['community_bio'],
            'community_structure' => $validated['community_structure'],
            'slogan' => $validated['slogan'],
            'community_name' => $validated['community_name'],
            'sender' => $validated['sender'],
            'endpoint' => $validated['endpoint'],
            'api_key' => $validated['api_key'],
        ]);

        $this->updateFile($request, 'image', 'setting_image', $setting);
        $this->updateFile($request, 'video1', 'setting_videos', $setting);
        $this->updateFile($request, 'video2', 'setting_videos', $setting);
        $this->updateFile($request, 'video', 'setting_videos', $setting);

        $setting->save();
        return redirect()->route('admin.settings.index', ['setting' => $setting->id])->with('success', 'Setting updated successfully');
    }

    private function updateFile(Request $request, $inputName, $folder, $setting)
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);

            // Validate if the file is uploaded successfully
            if ($file->isValid()) {
                $slug = Str::slug($file->getClientOriginalName());
                $newFileName = time() . '_' . $slug;
                $file->move($folder . '/', $newFileName);
                $setting->$inputName = $folder . '/' . $newFileName;
            }
        } elseif ($request->has($inputName . '_remove')) {
            // Optionally, you can delete the old file here if needed
            $setting->$inputName = null;
        }
    }
}
