<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Setting;
use App\Models\ThemeSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemeSettingTest extends TestCase
{
    use RefreshDatabase;

    // -----------------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------------

    private function makeWebAdmin(): User
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Website-admin']);
        $user->roles()->attach($role);

        return $user;
    }

    private function makeRegularUser(): User
    {
        return User::factory()->create();
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'is_enabled'       => '0',
            'primary_color'    => '#4BAF47',
            'secondary_color'  => '#938A42',
            'accent_color'     => '#ED8A19',
            'dark_color'       => '#24231D',
            'light_color'      => '#F8F7F0',
            'body_color'       => '#FFFFFF',
            'header_text_mode' => 'light',
            'body_font'        => 'default',
            'heading_font'     => 'default',
        ], $overrides);
    }

    // -----------------------------------------------------------------------
    // 1. Unauthorized access
    // -----------------------------------------------------------------------

    public function test_guest_cannot_access_theme_settings_page(): void
    {
        $response = $this->get('/theme-settings/edit');

        $response->assertRedirect('/login');
    }

    public function test_regular_user_cannot_access_theme_settings_page(): void
    {
        $user = $this->makeRegularUser();

        $response = $this->actingAs($user)->get('/theme-settings/edit');

        $response->assertForbidden();
    }

    public function test_regular_user_cannot_update_theme_settings(): void
    {
        $user = $this->makeRegularUser();

        $response = $this->actingAs($user)
            ->put('/theme-settings', $this->validPayload());

        $response->assertForbidden();
    }

    // -----------------------------------------------------------------------
    // 2. Authorized access
    // -----------------------------------------------------------------------

    public function test_website_admin_can_access_theme_settings_page(): void
    {
        $admin = $this->makeWebAdmin();

        $response = $this->actingAs($admin)->get('/theme-settings/edit');

        $response->assertOk();
    }

    // -----------------------------------------------------------------------
    // 3. Valid colors can be saved
    // -----------------------------------------------------------------------

    public function test_website_admin_can_save_valid_colors(): void
    {
        $admin = $this->makeWebAdmin();

        $response = $this->actingAs($admin)
            ->put('/theme-settings', $this->validPayload([
                'is_enabled'    => '1',
                'primary_color' => '#E05E4E',
            ]));

        $response->assertRedirect('/theme-settings/edit');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('theme_settings', [
            'primary_color' => '#E05E4E',
            'is_enabled'    => true,
        ]);
    }

    // -----------------------------------------------------------------------
    // 4. Invalid color values are rejected
    // -----------------------------------------------------------------------

    public function test_invalid_color_format_is_rejected(): void
    {
        $admin = $this->makeWebAdmin();

        $response = $this->actingAs($admin)
            ->put('/theme-settings', $this->validPayload([
                'primary_color' => 'not-a-color',
            ]));

        $response->assertSessionHasErrors('primary_color');
    }

    public function test_short_hex_is_rejected(): void
    {
        $admin = $this->makeWebAdmin();

        $response = $this->actingAs($admin)
            ->put('/theme-settings', $this->validPayload([
                'accent_color' => '#ED8',
            ]));

        $response->assertSessionHasErrors('accent_color');
    }

    public function test_color_without_hash_is_rejected(): void
    {
        $admin = $this->makeWebAdmin();

        $response = $this->actingAs($admin)
            ->put('/theme-settings', $this->validPayload([
                'dark_color' => '24231D',
            ]));

        $response->assertSessionHasErrors('dark_color');
    }

    // -----------------------------------------------------------------------
    // 5. Custom theme defaults to disabled
    // -----------------------------------------------------------------------

    public function test_theme_is_disabled_by_default(): void
    {
        $theme = ThemeSetting::current();

        $this->assertFalse($theme->is_enabled);
    }

    // -----------------------------------------------------------------------
    // 6. No style override rendered when disabled
    // -----------------------------------------------------------------------

    public function test_theme_style_block_is_not_rendered_when_disabled(): void
    {
        Setting::create([]);
        ThemeSetting::create(array_merge(ThemeSetting::DEFAULTS, ['is_enabled' => false]));

        $response = $this->get('/donate-success');

        $response->assertOk();
        $response->assertDontSee('dynamic-site-theme');
    }

    // -----------------------------------------------------------------------
    // 7. Theme variables rendered when enabled
    // -----------------------------------------------------------------------

    public function test_theme_style_block_is_rendered_when_enabled(): void
    {
        Setting::create([]);
        ThemeSetting::create(array_merge(ThemeSetting::DEFAULTS, ['is_enabled' => true]));

        $response = $this->get('/donate-success');

        $response->assertOk();
        $response->assertSee('dynamic-site-theme', false);
        $response->assertSee('--theme-color', false);
    }

    // -----------------------------------------------------------------------
    // 8. Reset restores defaults and disables the theme
    // -----------------------------------------------------------------------

    public function test_reset_restores_defaults_and_disables_theme(): void
    {
        $admin = $this->makeWebAdmin();

        ThemeSetting::create(array_merge(ThemeSetting::DEFAULTS, [
            'is_enabled'    => true,
            'primary_color' => '#E05E4E',
        ]));

        $response = $this->actingAs($admin)
            ->post('/theme-settings/reset');

        $response->assertRedirect('/theme-settings/edit');
        $response->assertSessionHas('success');

        $theme = ThemeSetting::first();
        $this->assertFalse($theme->is_enabled);
        $this->assertSame('#4BAF47', $theme->primary_color);
    }

    // -----------------------------------------------------------------------
    // 9. No settings row does not cause an error
    // -----------------------------------------------------------------------

    public function test_frontend_loads_with_no_theme_settings_row(): void
    {
        Setting::create([]);
        $this->assertDatabaseCount('theme_settings', 0);

        $response = $this->get('/donate-success');

        $response->assertOk();
    }

    // -----------------------------------------------------------------------
    // 10. Existing public pages continue loading
    // -----------------------------------------------------------------------

    public function test_frontend_page_loads_successfully(): void
    {
        Setting::create([]);

        $response = $this->get('/donate-success');

        $response->assertOk();
    }

    // -----------------------------------------------------------------------
    // Colors are normalized to uppercase on save
    // -----------------------------------------------------------------------

    public function test_colors_are_normalized_to_uppercase(): void
    {
        $admin = $this->makeWebAdmin();

        $this->actingAs($admin)
            ->put('/theme-settings', $this->validPayload([
                'primary_color' => '#e05e4e',
            ]));

        $this->assertDatabaseHas('theme_settings', ['primary_color' => '#E05E4E']);
    }

    // -----------------------------------------------------------------------
    // Font settings — valid values accepted
    // -----------------------------------------------------------------------

    public function test_valid_body_font_is_accepted(): void
    {
        $admin = $this->makeWebAdmin();

        $response = $this->actingAs($admin)
            ->put('/theme-settings', $this->validPayload(['body_font' => 'montserrat']));

        $response->assertRedirect('/theme-settings/edit');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('theme_settings', ['body_font' => 'montserrat']);
    }

    public function test_valid_heading_font_is_accepted(): void
    {
        $admin = $this->makeWebAdmin();

        $response = $this->actingAs($admin)
            ->put('/theme-settings', $this->validPayload(['heading_font' => 'dm-serif-display']));

        $response->assertRedirect('/theme-settings/edit');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('theme_settings', ['heading_font' => 'dm-serif-display']);
    }

    // -----------------------------------------------------------------------
    // Font settings — invalid values rejected
    // -----------------------------------------------------------------------

    public function test_invalid_body_font_is_rejected(): void
    {
        $admin = $this->makeWebAdmin();

        $response = $this->actingAs($admin)
            ->put('/theme-settings', $this->validPayload(['body_font' => 'comic-sans']));

        $response->assertSessionHasErrors('body_font');
    }

    public function test_invalid_heading_font_is_rejected(): void
    {
        $admin = $this->makeWebAdmin();

        $response = $this->actingAs($admin)
            ->put('/theme-settings', $this->validPayload(['heading_font' => 'papyrus']));

        $response->assertSessionHasErrors('heading_font');
    }

    // -----------------------------------------------------------------------
    // Font settings — defaults persisted correctly
    // -----------------------------------------------------------------------

    public function test_default_fonts_are_persisted(): void
    {
        $admin = $this->makeWebAdmin();

        $this->actingAs($admin)
            ->put('/theme-settings', $this->validPayload([
                'body_font'    => 'default',
                'heading_font' => 'default',
            ]));

        $this->assertDatabaseHas('theme_settings', [
            'body_font'    => 'default',
            'heading_font' => 'default',
        ]);
    }

    // -----------------------------------------------------------------------
    // Font variables not output when fonts are default
    // -----------------------------------------------------------------------

    public function test_font_variables_not_output_when_default(): void
    {
        Setting::create([]);
        ThemeSetting::create(array_merge(ThemeSetting::DEFAULTS, [
            'is_enabled'   => true,
            'body_font'    => 'default',
            'heading_font' => 'default',
        ]));

        $response = $this->get('/donate-success');

        $response->assertOk();
        $response->assertDontSee('--theme-body-font', false);
        $response->assertDontSee('--theme-heading-font', false);
    }

    // -----------------------------------------------------------------------
    // Font variables output when non-default font is active
    // -----------------------------------------------------------------------

    public function test_body_font_variable_is_output_when_enabled(): void
    {
        Setting::create([]);
        ThemeSetting::create(array_merge(ThemeSetting::DEFAULTS, [
            'is_enabled' => true,
            'body_font'  => 'source-sans-3',
        ]));

        $response = $this->get('/donate-success');

        $response->assertOk();
        $response->assertSee('--theme-body-font', false);
        $response->assertSee('Source Sans 3', false);
    }

    public function test_heading_font_variable_is_output_when_enabled(): void
    {
        Setting::create([]);
        ThemeSetting::create(array_merge(ThemeSetting::DEFAULTS, [
            'is_enabled'   => true,
            'heading_font' => 'dm-serif-display',
        ]));

        $response = $this->get('/donate-success');

        $response->assertOk();
        $response->assertSee('--theme-heading-font', false);
        $response->assertSee('DM Serif Display', false);
    }

    // -----------------------------------------------------------------------
    // Reset restores default font values
    // -----------------------------------------------------------------------

    public function test_reset_restores_default_font_values(): void
    {
        $admin = $this->makeWebAdmin();

        ThemeSetting::create(array_merge(ThemeSetting::DEFAULTS, [
            'is_enabled'   => true,
            'body_font'    => 'montserrat',
            'heading_font' => 'dm-serif-display',
        ]));

        $this->actingAs($admin)->post('/theme-settings/reset');

        $theme = ThemeSetting::first();
        $this->assertSame('default', $theme->body_font);
        $this->assertSame('default', $theme->heading_font);
    }
}
