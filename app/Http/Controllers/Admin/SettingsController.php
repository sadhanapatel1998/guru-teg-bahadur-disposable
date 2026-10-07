<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;


class SettingsController extends Controller
{
    public function __construct(
        private ImageService $imageService
    ) {}

    public function general()
    {
        $settings = Setting::pluck('value', 'key');

        return view('admin.settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        foreach (
            $request->except([
                '_token',
                'site_logo',
                'site_favicon'
            ]) as $key => $value
        ) {

            $group = 'general';

            // SMTP Fields
            if (str_starts_with($key, 'mail_')) {
                $group = 'smtp';
            }

            // SEO Fields
            if (in_array($key, [
                'meta_title',
                'meta_description',
                'meta_keywords',
                'meta_robots',
                'canonical_url',
                'google_analytics_id'
            ])) {
                $group = 'seo';
            }

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => $group,
                ]
            );
        }

        // Site Logo
        if ($request->hasFile('site_logo')) {

            $path = $this->imageService->store(
                $request->file('site_logo'),
                'settings'
            );

            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                [
                    'value' => $path,
                    'group' => 'general',
                ]
            );
        }

        // Site Favicon
        if ($request->hasFile('site_favicon')) {

            $path = $this->imageService->store(
                $request->file('site_favicon'),
                'settings'
            );

            Setting::updateOrCreate(
                ['key' => 'site_favicon'],
                [
                    'value' => $path,
                    'group' => 'general',
                ]
            );
        }

        return back()->with(
            'success',
            'Settings updated successfully.'
        );
    }




public function storageLink()
{
    try {

        if (!file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }

        return back()->with('success', 'Storage link created successfully.');

    } catch (\Exception $e) {

        return back()->with('error', $e->getMessage());
    }
}

public function clearCache()
    {
        try {

            Artisan::call('optimize:clear');

            return back()->with(
                'success',
                'Application cache cleared successfully.'
            );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }


}