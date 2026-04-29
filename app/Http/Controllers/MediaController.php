<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\MediaType;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends BaseController
{
    /**
     * Validation rules
     * (Project standard: before store/update)
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'media_type_id' => ['required', 'exists:media_types,id'],

            'title_en' => ['required', 'string', 'max:255'],
            'title_es' => ['required', 'string', 'max:255'],

            'description_en' => ['nullable', 'string'],
            'description_es' => ['nullable', 'string'],

            'external_link' => ['nullable', 'url', 'max:2048'],

            'published_at' => ['nullable', 'date'],

            'is_published' => ['required', 'boolean'],
        ]);
    }

    public function indexPublic()
    {
        $mediaTypes = MediaType::visible()
            ->orderBy('name')
            ->get();

        return view('frontend.media-types.index', compact('mediaTypes'));
    }

    /**
     * Display media items by media type (slug-based).
     * URL: /media/{slug}
     */
    public function byType(string $slug): View
    {
        $type = MediaType::visible()
            ->where('slug', $slug)
            ->firstOrFail();

        $media = $type->media()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->get();

        return view('frontend.media.by-type', [
            'type' => $type,
            'media' => $media,
        ]);
    }

    /**
     * Display a listing of media.
     */
    /**
     * Display a listing of media.
     */
    public function index()
    {
        $media = Media::latest()->paginate(18);

        return view('admin.media.index', compact('media'));
    }

    /**
     * Download media file.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    /**
     * Download media file.
     */
    public function download(Media $media)
    {
        $disk = Storage::disk($media->disk);

        $stream = $disk->readStream($media->path);

        return response()->streamDownload(function () use ($stream) {
            fpassthru($stream);
        }, basename($media->path));
    }

    /**
     * Show the form for creating a new media item.
     */
    public function create()
    {
        $mediaTypes = MediaType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.media.form', compact('mediaTypes'));
    }

    /**
     * Store a newly created media item.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        try {
            $media = Media::create($data);

            SystemLogger::log(
                'Media created',
                'info',
                'media.store',
                [
                    'media_id' => $media->id,
                    'media_type' => $media->type->name ?? null,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('media.index')
                ->with('success', 'Media created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Media creation failed',
                'error',
                'media.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create media.');
        }
    }

    /**
     * Show the form for editing the specified media item.
     */
    public function edit(Media $media)
    {
        $mediaTypes = MediaType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.media.form', compact('media', 'mediaTypes'));
    }

    /**
     * Update the specified media item.
     */
    public function update(Request $request, Media $media)
    {
        $data = $this->validatedData($request);

        try {
            $media->update($data);

            SystemLogger::log(
                'Media updated',
                'info',
                'media.update',
                [
                    'media_id' => $media->id,
                    'media_type' => $media->type->name ?? null,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('media.index')
                ->with('success', 'Media updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Media update failed',
                'error',
                'media.update',
                [
                    'media_id' => $media->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update media.');
        }
    }

    /**
     * Remove the specified media item.
     */
    public function destroy(Media $media)
    {
        try {
            $media->delete();

            SystemLogger::log(
                'Media deleted',
                'warning',
                'media.delete',
                [
                    'media_id' => $media->id,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('media.index')
                ->with('success', 'Media deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Media deletion failed',
                'error',
                'media.delete',
                [
                    'media_id' => $media->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete media.');
        }
    }
}
