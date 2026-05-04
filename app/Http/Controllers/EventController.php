<?php

namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Event;
use App\Services\SystemLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class EventController extends BaseController
{
    /**
     * Public: list all published events
     */
    public function indexPublic()
    {
        $events = Event::visible()
            ->orderBy('event_date')
            ->get();

        return view('frontend.events.index', compact('events'));
    }

    /**
     * Public: display a single event
     */
    public function display(Event $event)
    {
        abort_unless($event->is_published, 404);

        return view('frontend.events.show', compact('event'));
    }

    /**
     * Admin: list all events
     */
    public function index()
    {
        $events = Event::orderByDesc('event_date')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.events.form');
    }

    /**
     * Validation method (standard)
     */
    protected function validateRequest(Request $request): array
    {
        return $request->validate([
            'title_en' => 'required|string|max:255',
            'title_es' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_es' => 'nullable|string',
            'event_date' => 'nullable|date',
            'publish_start_at' => 'nullable|date',
            'publish_end_at' => 'nullable|date|after_or_equal:publish_start_at',
            'is_published' => 'nullable|boolean',
            'image_url' => 'nullable|string|max:255',
            'file_url_en' => 'nullable|string|max:255',
            'file_url_es' => 'nullable|string|max:255',
            'external_link' => 'nullable|url|max:255',
            'external_link_button_text' => 'nullable|string|max:255',
        ]);
    }

    /**
     * Prepare data (fallback logic)
     */
    protected function prepareData(array $data): array
    {
        $data['title_es'] = $data['title_es'] ?: $data['title_en'];
        $data['content_es'] = $data['content_es'] ?: $data['content_en'];

        return $data;
    }

    /**
     * Store event
     */
    public function store(Request $request)
    {
        $data = $this->validateRequest($request);
        $data = $this->prepareData($data);

        try {
            DB::transaction(function () use ($data) {
                Event::create($data);
            });

            return redirect()
                ->route('events.index')
                ->with('success', 'Event created successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Event creation failed',
                'error',
                'events.store',
                [
                    'exception' => $e->getMessage(),
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create event.');
        }
    }

    /**
     * Show edit form
     */
    public function edit(Event $event)
    {
        return view('admin.events.form', compact('event'));
    }

    /**
     * Update event
     */
    public function update(Request $request, Event $event)
    {
        $data = $this->validateRequest($request);
        $data = $this->prepareData($data);

        try {
            DB::transaction(function () use ($event, $data) {
                $event->update($data);
            });

            return redirect()
                ->route('events.index')
                ->with('success', 'Event updated successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Event update failed',
                'error',
                'events.update',
                [
                    'exception' => $e->getMessage(),
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update event.');
        }
    }

    /**
     * Delete event
     */
    public function destroy(Event $event)
    {
        try {
            DB::transaction(function () use ($event) {

                if (! empty($event->file_url_en)) {
                    S3::delete($event->file_url_en);
                }

                if (! empty($event->file_url_es)) {
                    S3::delete($event->file_url_es);
                }

                $event->delete();
            });

            return redirect()
                ->route('events.index')
                ->with('success', 'Event deleted successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Event deletion failed',
                'error',
                'events.delete',
                [
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to delete event.');
        }
    }
}
