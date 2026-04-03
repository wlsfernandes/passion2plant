<?php

namespace App\Providers;

use App\Models\About;
use App\Models\Blog;
use App\Models\BookRecommendation;
use App\Models\Collaborator;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Footer;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Position;
use App\Models\Project;
use App\Models\Resource;
use App\Models\Sector;
use App\Models\Service;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        view()->composer('frontend.*', function ($view) {

            $settings = Setting::query()->first();

            $footer = Footer::query()->first();

            $socialLinks = SocialLink::query()
                ->where('is_published', true)
                ->ordered()
                ->get();

            $aboutSections = About::visible()->get()->keyBy('section');
            $featuredTestimonials = Testimonial::visible()->get();

            $featuredTeams = Team::visible()
                ->with('sectors')
                ->inRandomOrder()
                ->limit(4)
                ->get();

            $partnerLogos = Partner::visible()->get();

            $featuredServices = Service::visible()
                ->latest()
                ->limit(3)
                ->get();

            $featuredBlogs = Blog::visible()
                ->latest()
                ->limit(3)
                ->get();
            $blogs = Blog::visible()
                ->orderByDesc('created_at')
                ->get();
            $events = Event::visible()
                ->orderByDesc('created_at')
                ->get();
            $teams = Team::visible()
                ->orderByDesc('created_at')
                ->get();
            $services = Service::visible()
                ->orderByDesc('created_at')
                ->get();

            $featuredEvents = Event::visible()
                ->latest()
                ->limit(3)
                ->get();
            $pages = Page::visible()->get();
            $positions = Position::visible()->get();
            $projects = Project::visible()->orderBy('order')->get();

            $collaborators = Collaborator::visible()->orderBy('order')->get();
            $featuredDonations = Donation::inRandomOrder()
                ->limit(3)
                ->get();
            $menu = MenuItem::query()
                ->main()
                ->with('children')
                ->orderBy('order')
                ->get();
            $footerMenu = MenuItem::footerMenu();
            $sectors = Sector::orderBy('id')
                ->with(['teams' => function ($query) {
                    $query->visible()
                        ->orderBy('name');
                }])
                ->get();
            $resources = Resource::visible()->latest()->get();
            $books = BookRecommendation::latest()->get();
            $donations = Donation::latest()->get();

            $view->with([
                'settings' => $settings,
                'socialLinks' => $socialLinks,
                'aboutSections' => $aboutSections,
                'featuredTeams' => $featuredTeams,
                'featuredTestimonials' => $featuredTestimonials,
                'partnerLogos' => $partnerLogos,
                'featuredServices' => $featuredServices,
                'featuredBlogs' => $featuredBlogs,
                'footer' => $footer,
                'blogs' => $blogs,
                'events' => $events,
                'teams' => $teams,
                'services' => $services,
                'featuredEvents' => $featuredEvents,
                'pages' => $pages,
                'projects' => $projects,
                'collaborators' => $collaborators,
                'featuredDonations' => $featuredDonations,
                'menu' => $menu,
                'sectors' => $sectors,
                'positions' => $positions,
                'resources' => $resources,
                'books' => $books,
                'donations' => $donations,
                'footerMenu' => $footerMenu,

            ]);
        });
    }
}
