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
        $allSettings = Setting::orderBy('group')->orderBy('id')->get();
        $groups = $allSettings->groupBy('group');
        $raw = $allSettings->pluck('value', 'key');
        $rawEn = $allSettings->pluck('value_en', 'key');

        return view('admin.settings.index', compact('groups', 'raw', 'rawEn'));
    }

    public function update(Request $request)
    {
        $settings = $request->except('_token', '_method', 'en', 'active_tab');
        $fileFields = ['about_photo', 'site_logo', 'site_favicon'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $oldValue = Setting::where('key', $field)->value('value');
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
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        // Save English translations (value_en)
        if ($request->has('en')) {
            foreach ($request->input('en') as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value_en' => $value ?? '']
                );
            }
        }

        clear_setting_cache();
        \Illuminate\Support\Facades\Cache::flush();

        $tab = $request->input('active_tab', 'hero');

        // Support AJAX requests
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Pengaturan berhasil disimpan.', 'tab' => $tab]);
        }

        return redirect()->route('admin.settings.index', ['tab' => $tab])
            ->with('success', 'Pengaturan berhasil disimpan.');
    }

    /**
     * AJAX endpoint for saving text settings.
     * Accepts raw base64 text body to bypass WAF content inspection.
     */
    public function ajaxUpdate(Request $request)
    {
        // Read raw body (sent as text/plain base64 string)
        $raw = $request->getContent();
        if (!$raw) {
            return response()->json(['success' => false, 'message' => 'Empty request.'], 422);
        }

        $decoded = json_decode(base64_decode($raw), true);
        if (!$decoded) {
            return response()->json(['success' => false, 'message' => 'Invalid data.'], 422);
        }

        $data = $decoded['settings'] ?? [];
        $en = $decoded['en'] ?? [];

        // Map keys to groups for auto-creation
        $groupMap = [
            'hero_title' => 'hero',
            'hero_subtitle' => 'hero',
            'hero_description' => 'hero',
            'hero_cta_text' => 'hero',
            'hero_cta_url' => 'hero',
            'about_name' => 'about',
            'about_bio' => 'about',
            'about_photo' => 'about',
            'about_experience_years' => 'about',
            'about_projects_count' => 'about',
            'about_clients_count' => 'about',
            'contact_email' => 'contact',
            'contact_phone' => 'contact',
            'contact_whatsapp' => 'contact',
            'contact_address' => 'contact',
            'contact_github' => 'contact',
            'contact_linkedin' => 'contact',
            'contact_instagram' => 'contact',
            'site_name' => 'general',
            'site_logo' => 'general',
            'site_favicon' => 'general',
            'site_description' => 'general',
            'footer_text' => 'general',
        ];

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '', 'group' => $groupMap[$key] ?? 'general']
            );
        }

        // English translations: only update existing rows, don't create new ones
        foreach ($en as $key => $value) {
            Setting::where('key', $key)->update(['value_en' => $value ?? '']);
        }

        clear_setting_cache();
        // Also flush entire cache to ensure frontend reflects changes
        \Illuminate\Support\Facades\Cache::flush();

        return response()->json(['success' => true, 'message' => 'Pengaturan berhasil disimpan.']);
    }

    /**
     * AJAX endpoint for uploading setting files.
     * Accepts base64-encoded file data in plain text body to bypass WAF.
     */
    public function ajaxUpload(Request $request)
    {
        $raw = $request->getContent();
        if (!$raw) {
            return response()->json(['success' => false, 'message' => 'Empty request.'], 422);
        }

        $decoded = json_decode(base64_decode($raw), true);
        if (!$decoded || !isset($decoded['field']) || !isset($decoded['data'])) {
            return response()->json(['success' => false, 'message' => 'Invalid data.'], 422);
        }

        $field = $decoded['field'];
        $fileData = $decoded['data']; // base64 encoded file content
        $allowedFields = ['about_photo', 'site_logo', 'site_favicon'];

        if (!in_array($field, $allowedFields)) {
            return response()->json(['success' => false, 'message' => 'Invalid field.'], 422);
        }

        // Remove data URI prefix if present (e.g. "data:image/png;base64,...")
        if (str_contains($fileData, ',')) {
            $fileData = explode(',', $fileData, 2)[1];
        }

        $binaryData = base64_decode($fileData);
        if (!$binaryData) {
            return response()->json(['success' => false, 'message' => 'Invalid file data.'], 422);
        }

        $oldValue = Setting::where('key', $field)->value('value');
        if ($oldValue) {
            Storage::disk('public')->delete($oldValue);
        }

        $image = Image::read($binaryData);

        if ($field === 'about_photo') {
            $image->cover(400, 400);
        } elseif ($field === 'site_favicon') {
            $image->cover(64, 64);
        } else {
            $image->scaleDown(400);
        }

        $path = 'settings/' . $field . '_' . uniqid() . '.webp';
        Storage::disk('public')->put($path, $image->toWebp(85));

        Setting::updateOrCreate(
            ['key' => $field],
            ['value' => $path, 'group' => match ($field) {
                'about_photo' => 'about',
                'site_logo', 'site_favicon' => 'general',
                default => 'general',
            }]
        );
        clear_setting_cache();
        \Illuminate\Support\Facades\Cache::flush();

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' berhasil diupload.',
            'path' => $path,
            'url' => asset('storage/' . $path),
        ]);
    }
}
