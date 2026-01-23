<?php
namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Page;
use App\Models\Section;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SectionController extends BaseController
{
    /**
     * Validation rules
     */
    protected function validateData(Request $request): array
    {
        return $request->validate([
            'sort_order'    => ['nullable', 'integer'],
            'title_en'      => ['nullable', 'string', 'max:255'],
            'title_es'      => ['nullable', 'string', 'max:255'],
            'content_en'    => ['nullable', 'string'],
            'content_es'    => ['nullable', 'string'],
            'is_published'  => ['nullable', 'boolean'],
            'external_link' => ['nullable', 'url', 'max:255'],
            'button_text'   => ['nullable', 'string', 'max:100'],
            'image'         => 'nullable|image|max:2048',
        ]);
    }

    /**
     * List sections for a page
     */
    public function index(Page $page): View
    {
        $sections = $page->sections()
            ->orderBy('sort_order')
            ->get();

        return view('admin.pages.sections.index', compact('page', 'sections'));
    }

    /**
     * Create section form
     */
    public function create(Page $page): View
    {
        return view('admin.pages.sections.form', compact('page'));
    }

    /**
     * Store new section
     */
    public function store(Request $request, Page $page): RedirectResponse
    {
        try {
            $data            = $this->validateData($request);
            $data['page_id'] = $page->id;
            if ($request->hasFile('image_url')) {
                $data['image_url'] = S3::uploadImageAsWebp(
                    $request->file('image_url'),
                    'pages/sections'
                );
            }
            $section = Section::create($data);

            SystemLogger::log(
                'Page section created',
                'info',
                'page_sections.create',
                [
                    'page_id'    => $page->id,
                    'section_id' => $section->id,
                ]
            );

            return redirect()
                ->route('pages.sections.index', ['page' => $page])
                ->with('success', 'Section created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Page section creation failed',
                'error',
                'page_sections.create',
                [
                    'page_id'   => $page->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->withInput()->with('error', 'Failed to create section.');
        }
    }

    /**
     * Edit section form
     */
    public function edit(Page $page, Section $section)
    {

        return view('admin.pages.sections.form', compact('page', 'section'));
    }

    /**
     * Update section
     */
    public function update(
        Request $request,
        Page $page,
        Section $section
    ): RedirectResponse {
        try {
            $data = $this->validateData($request);
            if ($request->hasFile('image_url')) {
                $data['image_url'] = S3::uploadImageAsWebp(
                    $request->file('image_url'),
                    'pages/sections'
                );
            }
            $section->update($data);

            SystemLogger::log(
                'Page section updated',
                'info',
                'page_sections.update',
                [
                    'page_id'    => $page->id,
                    'section_id' => $section->id,
                ]
            );

            return redirect()
                ->route('pages.sections.index', ['page' => $page])
                ->with('success', 'Section updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Page section update failed',
                'error',
                'page_sections.update',
                [
                    'page_id'    => $page->id,
                    'section_id' => $section->id,
                    'exception'  => $e->getMessage(),
                ]
            );

            return back()->withInput()->with('error', 'Failed to update section.');
        }
    }

    /**
     * Delete section
     */
    public function destroy(Page $page, Section $section): RedirectResponse
    {
        try {
            $section->delete();

            SystemLogger::log(
                'Page section deleted',
                'warning',
                'page_sections.delete',
                [
                    'page_id'    => $page->id,
                    'section_id' => $section->id,
                ]
            );

            return redirect()
                ->route('pages.sections.index', ['page' => $page])
                ->with('success', 'Section deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Page section deletion failed',
                'error',
                'page_sections.delete',
                [
                    'page_id'    => $page->id,
                    'section_id' => $section->id,
                    'exception'  => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to delete section.');
        }
    }
}
