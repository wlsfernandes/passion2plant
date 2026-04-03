<?php

namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Footer;
use App\Services\SystemLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FooterController extends BaseController
{
    private function validateData(Request $request): array
    {
        return $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'title_es' => ['nullable', 'string', 'max:255'],
            'subtitle_en' => ['nullable', 'string'],
            'subtitle_es' => ['nullable', 'string'],
            'image_url' => ['nullable', 'file', 'image', 'max:2048'], // ✅ important change
        ]);
    }

    /**
     * Show the footer editor (single record)
     */
    public function index()
    {
        $footer = Footer::first();

        return view('admin.footer.form', compact('footer'));
    }

    /**
     * Store or Update Footer (single record logic)
     */
    public function save(Request $request)
    {
        $data = $this->validateData($request);

        DB::beginTransaction();

        try {
            $footer = Footer::first();

            if ($request->hasFile('image_url')) {
                $data['image_url'] = S3::uploadImageAsWebpPreset(
                    $request->file('image_url'),
                    'footers', // ✅ better folder name
                    'cover',
                    1600,
                    600,
                    85
                );
            }

            if ($footer) {
                $footer->update($data);
            } else {
                $footer = Footer::create($data);
            }

            DB::commit();

            return redirect()
                ->route('footer.index')
                ->with('success', 'Footer saved successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();

            SystemLogger::log(
                'Failed to save footer',
                'error',
                'footers.save',
                [
                    'error' => $e->getMessage(),
                ]
            );

            return back()->withInput()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Validation logic
     */
}
