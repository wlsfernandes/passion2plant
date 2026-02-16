<?php
namespace App\Http\Controllers;

use App\Models\Page;

class PagePublicController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::visible()
            ->with('sections')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.pages.show', compact('page'));
    }
}
