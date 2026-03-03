<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $groups = Setting::orderBy('group')->orderBy('id')->get()->groupBy('group');

        return view('admin.settings.index', compact('groups'));
    }

    public function update(Request $request)
    {
        $settings = $request->except('_token', '_method', 'en');
        $fileFields = ['about_photo', 'site_logo', 'site_favicon'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $oldValue = setting($field);
                if ($oldValue) {
                    Storage::disk('public')->delete($oldValue);
                }

                $file = $request->file($field);
                $image = Image::read($file);

                if ($field === 'about_photo') {
                    $image->cover(400, 400);
                } elseif ($field === 'site_favicon') {
                    $image->cover(64, 64);
                } else {
                    $image->scaleDown(400);
                }

                $path = 'settings/' . $field . '_' . uniqid() . '.webp';
                Storage::disk('public')->put($path, $image->toWebp(85));

                Setting::where('key', $field)->update(['value' => $path]);
            }
            unset($settings[$field]);
        }

        foreach ($settings as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value ?? '']);
        }

        // Save English translations (value_en)
        if ($request->has('en')) {
            foreach ($request->input('en') as $key => $value) {
                Setting::where('key', $key)->update(['value_en' => $value ?? '']);
            }
        }

        clear_setting_cache();

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
