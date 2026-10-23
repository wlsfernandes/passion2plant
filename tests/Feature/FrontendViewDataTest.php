<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FrontendViewDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_shared_frontend_data_is_loaded_once_per_request(): void
    {
        Setting::create(['site_name' => 'Passion2Plant']);
        Page::create([
            'title_en' => 'Home',
            'title_es' => 'Inicio',
            'slug' => 'home',
            'is_published' => true,
        ]);
        MenuItem::create([
            'title_en' => 'About',
            'title_es' => 'Acerca',
            'link' => '/about-us',
            'order' => 0,
            'parent_id' => null,
        ]);

        DB::enableQueryLog();
        $response = $this->get('/');
        $blogQueries = collect(DB::getQueryLog())
            ->filter(fn (array $entry) => str_contains($entry['query'], 'from "blogs"'));

        $response->assertOk();
        // One query for all blogs, one for featured blogs.
        $this->assertCount(2, $blogQueries);
    }
}
