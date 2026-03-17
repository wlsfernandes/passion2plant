<?php

namespace App\Http\Controllers;

use App\Models\Page;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $page = Page::visible()
            ->where('slug', '/')
            ->with([
                'banners' => fn ($q) => $q->published()->orderBy('sort_order'),
                'sections' => fn ($q) => $q->published(),
            ])
            ->firstOrFail();

        return view('frontend.pages.show', compact('page'));
    }

    public function pulpitFellows()
    {
        return view('frontend.pulpit-fellows.index');
    }
}
