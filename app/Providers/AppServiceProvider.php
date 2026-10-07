<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Setting;
use App\Models\Page;



class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useBootstrapFive();
        // Share global settings with all views
        View::composer('*', function ($view) {
            try {
                $siteName    = Setting::get('site_name', 'Sanni Cad Cam');
                $siteLogo    = Setting::get('site_logo');
                 
                $footerPages = Page::where('status', 'published')
                    ->whereIn('slug', [
                        'privacy-policy',
                        'terms-conditions',
                        'shipping-policy',
                        'return-refund-policy'
                    ])
                    ->orderBy('title')
                    ->get();
                    

                $view->with(compact('siteName', 'siteLogo','footerPages'));
            } catch (\Exception $e) {
                // DB not ready yet (during migrations etc.)
            }
        });
    }
}
