<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    private function makeWebAdmin(): User
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Website-admin']);
        $user->roles()->attach($role);

        return $user;
    }

    private function createMenu(string $title, array $attributes = []): MenuItem
    {
        return MenuItem::create(array_merge([
            'title_en' => $title,
            'title_es' => $title.' ES',
            'link' => '/'.str($title)->slug(),
            'order' => 0,
            'parent_id' => null,
        ], $attributes));
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'title_en' => 'Programs',
            'title_es' => 'Programas',
            'link' => '/programs',
            'order' => 0,
            'parent_id' => null,
        ], $overrides);
    }

    public function test_root_menu_can_be_created(): void
    {
        $response = $this->actingAs($this->makeWebAdmin())
            ->post(route('menus.store'), $this->validPayload());

        $response->assertRedirect(route('menus.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('menu_items', [
            'title_en' => 'Programs',
            'parent_id' => null,
        ]);
    }

    public function test_child_and_grandchild_can_be_assigned_to_nested_parents(): void
    {
        $admin = $this->makeWebAdmin();

        $this->actingAs($admin)->post(route('menus.store'), $this->validPayload());
        $root = MenuItem::where('title_en', 'Programs')->firstOrFail();

        $this->actingAs($admin)->post(route('menus.store'), $this->validPayload([
            'title_en' => 'Certification',
            'parent_id' => $root->id,
        ]));
        $child = MenuItem::where('title_en', 'Certification')->firstOrFail();

        $response = $this->actingAs($admin)->post(route('menus.store'), $this->validPayload([
            'title_en' => 'Requirements',
            'parent_id' => $child->id,
        ]));

        $response->assertRedirect(route('menus.index'));
        $this->assertDatabaseHas('menu_items', [
            'title_en' => 'Certification',
            'parent_id' => $root->id,
        ]);
        $this->assertDatabaseHas('menu_items', [
            'title_en' => 'Requirements',
            'parent_id' => $child->id,
        ]);
    }

    public function test_admin_index_renders_every_menu_level_in_tree_order(): void
    {
        $root = $this->createMenu('Programs');
        $child = $this->createMenu('Certification', ['parent_id' => $root->id]);
        $this->createMenu('Requirements', ['parent_id' => $child->id]);

        $response = $this->actingAs($this->makeWebAdmin())->get(route('menus.index'));

        $response->assertOk();
        $response->assertSeeInOrder(['Programs', 'Certification', 'Requirements']);
        $response->assertSee('— — ', false);
    }

    public function test_frontend_navigation_renders_three_levels_with_accessible_controls(): void
    {
        Setting::create(['site_name' => 'Passion2Plant']);
        $root = $this->createMenu('Programs');
        $child = $this->createMenu('Certification', ['parent_id' => $root->id]);
        $grandchild = $this->createMenu('Requirements', ['parent_id' => $child->id]);

        $response = $this->get(route('pulpit-fellows'));

        $response->assertOk();
        $response->assertSeeInOrder(['Programs', 'Certification', 'Requirements']);
        $response->assertSee('aria-controls="submenu-'.$root->id.'"', false);
        $response->assertSee('aria-controls="submenu-'.$child->id.'"', false);
        $response->assertDontSee('id="submenu-'.$grandchild->id.'"', false);
        $this->assertSame(1, substr_count($response->getContent(), 'id="submenu-'.$root->id.'"'));
        $this->assertSame(1, substr_count($response->getContent(), 'id="submenu-'.$child->id.'"'));
    }

    public function test_item_cannot_be_its_own_parent(): void
    {
        $item = $this->createMenu('Programs');

        $response = $this->actingAs($this->makeWebAdmin())
            ->from(route('menus.edit', $item))
            ->put(route('menus.update', $item), $this->validPayload([
                'parent_id' => $item->id,
            ]));

        $response->assertRedirect(route('menus.edit', $item));
        $response->assertSessionHasErrors([
            'parent_id' => 'The selected parent would create an invalid menu hierarchy.',
        ]);
        $this->assertNull($item->fresh()->parent_id);
    }

    public function test_item_cannot_be_assigned_to_any_descendant(): void
    {
        $root = $this->createMenu('Programs');
        $child = $this->createMenu('Certification', ['parent_id' => $root->id]);
        $grandchild = $this->createMenu('Requirements', ['parent_id' => $child->id]);

        $response = $this->actingAs($this->makeWebAdmin())
            ->put(route('menus.update', $root), $this->validPayload([
                'parent_id' => $grandchild->id,
            ]));

        $response->assertSessionHasErrors('parent_id');
        $this->assertNull($root->fresh()->parent_id);
    }

    public function test_nonexistent_parent_is_rejected(): void
    {
        $response = $this->actingAs($this->makeWebAdmin())
            ->post(route('menus.store'), $this->validPayload(['parent_id' => 999999]));

        $response->assertSessionHasErrors('parent_id');
        $this->assertDatabaseMissing('menu_items', ['title_en' => 'Programs']);
    }

    public function test_valid_reparenting_succeeds(): void
    {
        $firstRoot = $this->createMenu('Programs');
        $secondRoot = $this->createMenu('Membership');
        $child = $this->createMenu('Certification', ['parent_id' => $firstRoot->id]);

        $response = $this->actingAs($this->makeWebAdmin())
            ->put(route('menus.update', $child), $this->validPayload([
                'title_en' => $child->title_en,
                'parent_id' => $secondRoot->id,
            ]));

        $response->assertRedirect(route('menus.index'));
        $this->assertSame($secondRoot->id, $child->fresh()->parent_id);
    }

    public function test_parent_selector_is_nested_and_excludes_item_and_descendants(): void
    {
        $otherRoot = $this->createMenu('Membership', ['order' => 1]);
        $root = $this->createMenu('Programs', ['order' => 2]);
        $child = $this->createMenu('Certification', ['parent_id' => $root->id]);
        $grandchild = $this->createMenu('Requirements', ['parent_id' => $child->id]);
        $admin = $this->makeWebAdmin();

        $createResponse = $this->actingAs($admin)->get(route('menus.create'));
        $createResponse->assertOk();
        $createResponse->assertSee('No parent / Top-level menu');
        $createResponse->assertSee('— Certification');
        $createResponse->assertSee('— — Requirements');

        $editResponse = $this->actingAs($admin)->get(route('menus.edit', $root));
        $editResponse->assertOk();
        $editResponse->assertSee('<option value="'.$otherRoot->id.'"', false);
        $editResponse->assertDontSee('<option value="'.$root->id.'"', false);
        $editResponse->assertDontSee('<option value="'.$child->id.'"', false);
        $editResponse->assertDontSee('<option value="'.$grandchild->id.'"', false);

        $childEditResponse = $this->actingAs($admin)->get(route('menus.edit', $child));
        $this->assertMatchesRegularExpression(
            '/<option value="'.$root->id.'"\s+selected>/',
            $childEditResponse->getContent()
        );
    }

    public function test_parent_selection_is_preserved_after_validation_failure(): void
    {
        $parent = $this->createMenu('Programs');

        $response = $this->actingAs($this->makeWebAdmin())
            ->from(route('menus.create'))
            ->post(route('menus.store'), $this->validPayload([
                'title_en' => '',
                'parent_id' => $parent->id,
            ]));

        $response->assertRedirect(route('menus.create'));
        $response->assertSessionHasInput('parent_id', $parent->id);
    }

    public function test_siblings_render_according_to_order_in_admin_and_frontend(): void
    {
        Setting::create(['site_name' => 'Passion2Plant']);
        $root = $this->createMenu('Programs');
        $this->createMenu('Application Process', ['parent_id' => $root->id, 'order' => 20]);
        $this->createMenu('Requirements', ['parent_id' => $root->id, 'order' => 10]);

        $adminResponse = $this->actingAs($this->makeWebAdmin())->get(route('menus.index'));
        $adminResponse->assertSeeInOrder(['Requirements', 'Application Process']);

        $frontendResponse = $this->get(route('pulpit-fellows'));
        $frontendResponse->assertSeeInOrder(['Requirements', 'Application Process']);
    }

    public function test_deleting_parent_promotes_immediate_children_to_root(): void
    {
        $parent = $this->createMenu('Programs');
        $child = $this->createMenu('Certification', ['parent_id' => $parent->id]);

        $response = $this->actingAs($this->makeWebAdmin())
            ->delete(route('menus.destroy', $parent));

        $response->assertRedirect(route('menus.index'));
        $this->assertDatabaseMissing('menu_items', ['id' => $parent->id]);
        $this->assertNull($child->fresh()->parent_id);
    }

    public function test_existing_two_level_menu_still_renders_on_frontend(): void
    {
        Setting::create(['site_name' => 'Passion2Plant']);
        $root = $this->createMenu('About');
        $child = $this->createMenu('Our Story', ['parent_id' => $root->id]);

        $response = $this->get(route('pulpit-fellows'));

        $response->assertOk();
        $response->assertSeeInOrder(['About', 'Our Story']);
        $response->assertSee('id="submenu-'.$root->id.'"', false);
        $response->assertDontSee('id="submenu-'.$child->id.'"', false);
    }
}
