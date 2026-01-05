<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('frontend.*', function ($view) {

            $settings = cache()->rememberForever('frontend_settings', function () {
                return Setting::current();
            });

            $view->with('settings', $settings);
        });
    }
}
