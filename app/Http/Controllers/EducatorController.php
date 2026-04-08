<?php

namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Educator;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;

class EducatorController extends BaseController
{
    /**
     * Validation rules
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_url' => ['nullable', 'string'],
            'external_link' => ['nullable', 'url'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Display a listing of educators.
     */
    public function index()
    {
        $educators = Educator::orderByDesc('created_at')->get();

        return view('admin.educators.index', compact('educators'));
    }

    /**
     * Show the form for creating a new educator.
     */
    public function create()
    {
        return view('admin.educators.form');
    }

    /**
     * Store a newly created educator.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        try {

            $educator = Educator::create($data);

            SystemLogger::log(
                'Educator created',
                'info',
                'educators.store',
                [
                    'partner_id' => $educator->id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('educators.index')
                ->with('success', 'Educator created successfully.');
        } catch (Exception $e) {

            SystemLogger::log(
                'Educator creation failed',
                'error',
                'educators.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()->withInput()
                ->with('error', 'Failed to create educator.');
        }
    }

    /**
     * Show the form for editing the specified educator.
     */
    public function edit(Educator $educator)
    {
        return view('admin.educators.form', compact('educator'));
    }

    /**
     * Update the specified educator.
     */
    public function update(Request $request, Educator $educator)
    {
        $data = $this->validatedData($request);
        try {

            $educator->update($data);

            SystemLogger::log(
                'Educator updated',
                'info',
                'educators.update',
                [
                    'partner_id' => $educator->id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('educators.index')
                ->with('success', 'Educator updated successfully.');
        } catch (Exception $e) {
            SystemLogger::log(
                'Educator update failed',
                'error',
                'educators.update',
                [
                    'partner_id' => $educator->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()->withInput()
                ->with('error', 'Failed to update educator.');
        }
    }

    /**
     * Remove the specified educator.
     */
    public function destroy(Educator $educator)
    {
        try {
            if (! empty($educator->image_url)) {
                S3::delete($educator->image_url);
            }

            $educator->delete();

            SystemLogger::log(
                'Educator deleted',
                'warning',
                'educators.delete',
                [
                    'partner_id' => $educator->id,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('educators.index')
                ->with('success', 'Educator deleted successfully.');
        } catch (Exception $e) {
            SystemLogger::log(
                'Educator deletion failed',
                'error',
                'educators.delete',
                [
                    'partner_id' => $educator->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()->with('error', 'Failed to delete educator.');
        }
    }
}
