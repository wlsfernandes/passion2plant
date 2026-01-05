<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Banner;
use App\Models\Setting;
use App\Models\SocialLink;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        view()->composer('frontend.*', function ($view) {

            $settings = cache()->rememberForever('frontend_settings', function () {
                return Setting::current();
            });

            $socialLinks = cache()->rememberForever('frontend_social_links', function () {
                return SocialLink::query()
                    ->where('is_published', true)
                    ->ordered()
                    ->get();
            });

            $banners = Banner::query()
                ->where('is_published', true)
                ->where(function ($q) {
                    $q->whereNull('publish_start_at')
                        ->orWhere('publish_start_at', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('publish_end_at')
                        ->orWhere('publish_end_at', '>=', now());
                })
                ->orderBy('sort_order')
                ->get();


            $view->with([
                'settings' => $settings,
                'socialLinks' => $socialLinks,
                'banners' => $banners,
            ]);
        });
    }
}