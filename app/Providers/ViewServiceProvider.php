<?php

namespace App\Providers;

use App\Models\Partner;
use Illuminate\Support\ServiceProvider;
use App\Models\About;
use App\Models\Blog;
use App\Models\Event;
use App\Models\Banner;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\Service;

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

            $aboutSections = About::visible()->get()->keyBy('section');
            $featuredTestimonials = Testimonial::visible()->get();

            $featuredTeams = Team::visible()
                ->inRandomOrder()
                ->limit(4)
                ->get();

            $partnerLogos = Partner::visible()->get();

            $featuredServices = Service::visible()
                ->inRandomOrder()
                ->limit(3)
                ->get();
            $featuredBlogs = Blog::visible()
                ->inRandomOrder()
                ->limit(3)
                ->get();

            $featuredEvents = Event::visible()
                ->inRandomOrder()
                ->limit(3)
                ->get();


            $view->with([
                'settings' => $settings,
                'socialLinks' => $socialLinks,
                'banners' => $banners,

                'aboutSections' => $aboutSections,

                'featuredTeams' => $featuredTeams,
                'featuredTestimonials' => $featuredTestimonials,
                'partnerLogos' => $partnerLogos,
                'featuredServices' => $featuredServices,
                'featuredBlogs' => $featuredBlogs,
                'featuredEvents' => $featuredEvents,
            ]);
        });
    }
}