<?php

namespace App\Http\Controllers;

use App\Models\ThemeSetting;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ThemeSettingController extends BaseController
{
    public function index()
    {
        return redirect()->route('theme-settings.edit');
    }

    public function edit()
    {
        $themeSetting = ThemeSetting::current();

        return view('admin.theme-settings.form', compact('themeSetting'));
    }

    public function update(Request $request)
    {
        $data = $this->validatedData($request);

        // Normalize colors to uppercase hex
        foreach (['primary_color', 'secondary_color', 'accent_color', 'dark_color', 'light_color', 'body_color'] as $field) {
            $data[$field] = strtoupper($data[$field]);
        }

        $themeSetting = ThemeSetting::current();

        try {
            $themeSetting->update($data);

            SystemLogger::log('Theme settings updated', 'info', 'theme-settings.update');

            return redirect()
                ->route('theme-settings.edit')
                ->with('success', 'Theme settings saved successfully.');

        } catch (Exception $e) {
            SystemLogger::log('Theme settings update failed', 'error', 'theme-settings.update', [
                'exception' => $e->getMessage(),
            ]);

            return back()->withInput()->with('error', 'Failed to save theme settings.');
        }
    }

    public function reset()
    {
        $themeSetting = ThemeSetting::current();

        try {
            $themeSetting->update(ThemeSetting::DEFAULTS);

            SystemLogger::log('Theme settings reset to defaults', 'info', 'theme-settings.reset');

            return redirect()
                ->route('theme-settings.edit')
                ->with('success', 'Theme settings reset to original colors.');

        } catch (Exception $e) {
            SystemLogger::log('Theme settings reset failed', 'error', 'theme-settings.reset', [
                'exception' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to reset theme settings.');
        }
    }

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'is_enabled'       => ['required', 'boolean'],
            'primary_color'    => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color'  => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'accent_color'     => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'dark_color'       => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'light_color'      => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'body_color'       => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'header_text_mode' => ['required', Rule::in(['light', 'dark'])],
            'body_font'        => ['required', Rule::in(array_keys(ThemeSetting::BODY_FONTS))],
            'heading_font'     => ['required', Rule::in(array_keys(ThemeSetting::HEADING_FONTS))],
        ]);
    }
}
