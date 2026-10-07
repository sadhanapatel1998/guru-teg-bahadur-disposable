<?php

if (!function_exists('base_public_url')) {

    function base_public_url($path = '')
    {
        return url('/public') . '/' . ltrim($path, '/');
    }

}

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return \App\Models\Setting::where('key', $key)->value('value') ?? $default;
    }
}

if (!function_exists('money')) {
    function money(float $amount): string
    {
        return setting('currency_symbol', '₹') . number_format($amount, 2);
    }
}

if (!function_exists('storage_url')) {
    function storage_url(?string $path, string $default = ''): string
    {
        if (!$path) return $default;
        return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
    }
}
