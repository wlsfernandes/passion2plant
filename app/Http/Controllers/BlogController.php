<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class BlogController extends BaseController
{
    /**
     * List all blogs (published + drafts).
     */
    public function index()
    {
        $blogs = Blog::orderByDesc('created_at')->get();

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.blogs.form');
    }

    /**
     * Store new blog.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_es' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_es' => 'nullable|string',
            'publish_start_at' => 'nullable|date',
            'publish_end_at' => 'nullable|date|after_or_equal:publish_start_at',
            'is_published' => 'nullable|boolean',
            'image_url' => 'nullable|string|max:255',
            'file_url_en' => 'nullable|string|max:255',
            'file_url_es' => 'nullable|string|max:255',
            'external_link' => 'nullable|url|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                Blog::create([
                    'title_en' => $request->title_en,
                    'title_es' => $request->title_es,
                    'content_en' => $request->content_en,
                    'content_es' => $request->content_es,
                    'publish_start_at' => $request->publish_start_at,
                    'publish_end_at' => $request->publish_end_at,
                    'is_published' => (bool) $request->is_published,
                    'image_url' => $request->image_url,
                    'file_url_en' => $request->file_url_en,
                    'file_url_es' => $request->file_url_es,
                    'external_link' => $request->external_link,
                ]);
            });

            return redirect()
                ->route('blogs.index')
                ->with('success', 'Blog created successfully.');

        } catch (Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create blog.');
        }
    }

    /**
     * Show edit form.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.form', compact('blog'));
    }

    /**
     * Update blog.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_es' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_es' => 'nullable|string',
            'publish_start_at' => 'nullable|date',
            'publish_end_at' => 'nullable|date|after_or_equal:publish_start_at',
            'is_published' => 'nullable|boolean',
            'image_url' => 'nullable|string|max:255',
            'file_url_en' => 'nullable|string|max:255',
            'file_url_es' => 'nullable|string|max:255',
            'external_link' => 'nullable|url|max:255',
        ]);

        try {
            DB::transaction(function () use ($request, $blog) {
                $blog->update($request->only([
                    'title_en',
                    'title_es',
                    'content_en',
                    'content_es',
                    'publish_start_at',
                    'publish_end_at',
                    'is_published',
                    'image_url',
                    'file_url_en',
                    'file_url_es',
                    'external_link',
                ]));
            });

            return redirect()
                ->route('blogs.index')
                ->with('success', 'Blog updated successfully.');

        } catch (Throwable $e) {
            return back()
                ->with('error', 'Failed to update blog.');
        }
    }

    /**
     * Delete blog.
     */
    public function destroy(Blog $blog)
    {
        try {
            $blog->delete();

            return redirect()
                ->route('blogs.index')
                ->with('success', 'Blog deleted successfully.');

        } catch (Throwable $e) {
            return back()->with('error', 'Failed to delete blog.');
        }
    }
}
