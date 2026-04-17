<?php

namespace App\Providers;

use App\Models\About;
use App\Models\Blog;
use App\Models\BookRecommendation;
use App\Models\Collaborator;
use App\Models\Donation;
use App\Models\Educator;
use App\Models\Event;
use App\Models\Footer;
use App\Models\Membership;
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

            $aboutSections = About::visible()->get()->keyBy('section');

            $blogs = Blog::visible()
                ->orderByDesc('created_at')
                ->get();

            $books = BookRecommendation::latest()->get();

            $collaborators = Collaborator::visible()
                ->orderBy('order')
                ->get();

            $donations = Donation::latest()->get();

            $educatorLogos = Educator::visible()->get();

            $events = Event::visible()
                ->orderByDesc('created_at')
                ->get();

            $featuredBlogs = Blog::visible()
                ->latest()
                ->limit(3)
                ->get();

            $featuredEvents = Event::visible()
                ->latest()
                ->limit(3)
                ->get();

            $featuredMemberships = Membership::all();

            $featuredTeams = Team::visible()
                ->with('sectors')
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get();

            $featuredTestimonials = Testimonial::visible()->get();

            $footer = Footer::query()->first();

            $footerMenu = MenuItem::query()
                ->main()
                ->orderBy('order')
                ->get();

            $memberships = Membership::latest()->get();

            $menu = MenuItem::query()
                ->main()
                ->with('children')
                ->orderBy('order')
                ->get();

            $pages = Page::visible()->get();

            $partnerLogos = Partner::visible()->get();

            $positions = Position::visible()->get();

            $projects = Project::visible()
                ->orderBy('order')
                ->get();

            $resources = Resource::visible()
                ->latest()
                ->get();

            $sectors = Sector::orderBy('id')
                ->with(['teams' => function ($query) {
                    $query->visible()
                        ->orderBy('last_name')
                        ->orderBy('first_name');
                }])
                ->get();

            $services = Service::visible()
                ->orderByDesc('created_at')
                ->get();

            $settings = Setting::query()->first();

            $socialLinks = SocialLink::query()
                ->where('is_published', true)
                ->ordered()
                ->get();

            $teams = Team::visible()->get();

            $view->with([
                'settings' => $settings,
                'socialLinks' => $socialLinks,
                'aboutSections' => $aboutSections,
                'featuredTeams' => $featuredTeams,
                'featuredTestimonials' => $featuredTestimonials,
                'partnerLogos' => $partnerLogos,
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
                'menu' => $menu,
                'sectors' => $sectors,
                'positions' => $positions,
                'resources' => $resources,
                'books' => $books,
                'donations' => $donations,
                'footerMenu' => $footerMenu,
                'educatorLogos' => $educatorLogos,
                'featuredMemberships' => $featuredMemberships,
                'memberships' => $memberships,

            ]);
        });
    }
}
