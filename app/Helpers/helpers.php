<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, mixed $default = null): mixed
    {
        $locale = app()->getLocale();
        $cacheKey = "setting_{$key}_{$locale}";

        return Cache::rememberForever($cacheKey, function () use ($key, $default) {
            return Setting::getValue($key, $default);
        });
    }
}

if (!function_exists('clear_setting_cache')) {
    /**
     * Clear cached settings.
     *
     * @param string|null $key
     * @return void
     */
    function clear_setting_cache(?string $key = null): void
    {
        if ($key) {
            Cache::forget("setting_{$key}_id");
            Cache::forget("setting_{$key}_en");
        } else {
            // Clear all setting caches
            $settings = Setting::all();
            foreach ($settings as $setting) {
                Cache::forget("setting_{$setting->key}_id");
                Cache::forget("setting_{$setting->key}_en");
            }
        }
    }
}
