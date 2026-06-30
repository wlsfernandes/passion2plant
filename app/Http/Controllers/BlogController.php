<?php

namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Blog;
use App\Services\SystemLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class BlogController extends BaseController
{
    /**
     * Public: list all published blogs
     * URL: /our-blogs
     */
    public function indexPublic()
    {
        $blogs = Blog::visible()
            ->orderByDesc('created_at')
            ->get();

        return view('frontend.blogs.index', compact('blogs'));
    }

    /**
     * Public: display a single blog by slug
     * URL: /blog/{slug}
     */
    public function display(Blog $blog)
    {
        abort_unless($blog->is_published, 404);

        return view('frontend.blogs.show', compact('blog'));
    }

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

    protected function validateRequest(Request $request): array
    {
        return $request->validate([
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
            'external_link_button_text' => 'nullable|string|max:255',
            'video_url' => 'nullable|url|max:255',
        ]);
    }

    protected function prepareData(array $data): array
    {
        // ES fallback
        $data['title_es'] = $data['title_es'] ?: $data['title_en'];
        $data['content_es'] = $data['content_es'] ?: $data['content_en'];

        return $data;
    }

    /**
     * Store new blog.
     */
    public function store(Request $request)
    {
        $data = $this->validateRequest($request);
        $data = $this->prepareData($data);

        try {
            DB::transaction(fn () => Blog::create($data));

            return redirect()
                ->route('blogs.index')
                ->with('success', 'Blog created successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Blog creation failed',
                'error',
                'blogs.store',
                [
                    'exception' => $e->getMessage(),
                ]
            );

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
        $data = $this->validateRequest($request);
        $data = $this->prepareData($data);

        try {
            DB::transaction(fn () => $blog->update($data));

            return redirect()
                ->route('blogs.index')
                ->with('success', 'Blog updated successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Blog update failed',
                'error',
                'blogs.update',
                [
                    'exception' => $e->getMessage(),
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update blog.');
        }
    }

    /**
     * Delete blog.
     */
    public function destroy(Blog $blog)
    {
        try {

            // 🔥 Delete English file if exists
            if (! empty($blog->file_url_en)) {
                S3::delete($blog->file_url_en);
            }

            // 🔥 Delete Spanish file if exists
            if (! empty($blog->file_url_es)) {
                S3::delete($blog->file_url_es);
            }

            $blog->delete();

            SystemLogger::log(
                'Blog deleted',
                'info',
                'blogs.delete',
                [
                    'blog_id' => $blog->id,
                    'title' => $blog->title_en,
                ]
            );

            return redirect()
                ->route('blogs.index')
                ->with('success', 'Blog deleted successfully.');

        } catch (Throwable $e) {
            SystemLogger::log(
                'Blog deletion failed',
                'error',
                'blogs.delete',
                [
                    'blog_id' => $blog->id ?? null,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to delete blog.');
        }
    }
}
