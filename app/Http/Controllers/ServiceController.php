<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\SystemLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ServiceController extends BaseController
{
    /**
     * List all services (published + drafts).
     */
    public function index()
    {
        $services = Service::orderByDesc('created_at')->get();

        return view('admin.services.index', compact('services'));
    }

    public function indexPublic()
    {
        $services = Service::visible()
            ->orderBy('title_en')
            ->get();

        return view('frontend.services.index', compact('services'));
    }

    /**
     * Display a specific service on the public site.
     */
    public function display(Service $service)
    {
        abort_unless($service->is_published, 404);

        return view('frontend.services.show', [
            // FULL list for sidebar
            'services' => Service::visible()->orderBy('title_en')->get(),

            // LIMITED list for carousel if needed
            'featuredServices' => Service::visible()->latest()->take(3)->get(),

            'service' => $service,
        ]);
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.services.form');
    }

    /**
     * Store new service.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_es' => 'nullable|string|max:255',

            'content_en' => 'nullable|string',
            'content_es' => 'nullable|string',

            'external_link' => 'nullable|url|max:255',
            'is_published' => 'nullable|boolean',
        ]);

        try {
            DB::transaction(function () use ($request) {
                Service::create([
                    'title_en' => $request->title_en,
                    'title_es' => $request->title_es,

                    'content_en' => $request->content_en,
                    'content_es' => $request->content_es,

                    'external_link' => $request->external_link,
                    'is_published' => (bool) $request->is_published,
                ]);
            });

            SystemLogger::log(
                'Service created',
                'info',
                'services.store',
                [
                    'email' => $request->email,
                    'roles' => $request->roles ?? [],
                ]
            );

            return redirect()
                ->route('services.index')
                ->with('success', 'Service created successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Service creation failed',
                'error',
                'services.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create service.');
        }
    }

    /**
     * Show edit form.
     */
    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    /**
     * Update service.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_es' => 'nullable|string|max:255',

            'content_en' => 'nullable|string',
            'content_es' => 'nullable|string',

            'external_link' => 'nullable|url|max:255',
            'is_published' => 'nullable|boolean',
        ]);

        try {
            DB::transaction(function () use ($request, $service) {
                $service->update($request->only([
                    'title_en',
                    'title_es',
                    'content_en',
                    'content_es',
                    'external_link',
                    'is_published',
                ]));
            });

            SystemLogger::log(
                'Service updated',
                'info',
                'services.update',
                [
                    'service_id' => $service->id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('services.index')
                ->with('success', 'Service updated successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Service update failed',
                'error',
                'services.update',
                [
                    'service_id' => $service->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()
                ->with('error', 'Failed to update service.');
        }
    }

    /**
     * Delete service.
     */
    public function destroy(Service $service)
    {
        try {
            // 🔥 Delete image if exists

            $service->delete();

            SystemLogger::log(
                'Service deleted',
                'info',
                'services.delete',
                [
                    'service_id' => $service->id,
                    'title' => $service->title_en,
                ]
            );

            return redirect()
                ->route('services.index')
                ->with('success', 'Service deleted successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Service deletion failed',
                'error',
                'services.delete',
                [
                    'service_id' => $service->id ?? null,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to delete service.');
        }
    }
}
