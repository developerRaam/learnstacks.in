<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit(Request $request){
        $data['heading_title'] = "Setting";
        $data['list_title'] = "Edit Setting";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Edit Setting',
            'href' => null
        ];

        $data['action'] = route('admin.updateSetting');

       // Default settings
        $settingArr = [
            'social_media_facebook_url' => null,
            'social_media_instagram_url' => null,
            'social_media_twitter_url' => null,
            'site_logo' => null,
            'site_description' => null,
            'site_name' => null,
        ];

        $settings = Setting::all();

        foreach ($settings as $setting) {
            if (array_key_exists($setting->key, $settingArr)) {
                $settingArr[$setting->key] = $setting->value;
            }
        }

        // Convert the array to an object if needed
        $data['setting'] = (object) $settingArr;

        return view("admin.setting.setting", $data);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'social_media_facebook_url' => 'nullable|url',
            'social_media_instagram_url' => 'nullable|url',
            'social_media_twitter_url' => 'nullable|url',
            'site_logo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'site_description' => 'nullable',
            'site_name' => 'nullable',
        ]);

        if ($request->hasFile('site_logo')) {
            $socialIconPath = $request->file('site_logo')->store('setting', 'public');
            $socialIconSetting = Setting::where('key', 'site_logo')->first();
            if ($socialIconSetting && $socialIconSetting->value) {
                Storage::disk('public')->delete($socialIconSetting->value);
            }
            $validatedData['site_logo'] = $socialIconPath;
        }

        // Iterate through the validated data and update each setting
        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value] 
            );
        }

        return redirect()->back()->with('success','Setting updated successfully');
    }
}
