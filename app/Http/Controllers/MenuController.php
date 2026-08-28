<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Services\SystemLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MenuController extends BaseController
{
    /**
     * Display a listing of the menu items.
     */
    public function index()
    {
        $menus = MenuItem::with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create()
    {
        $parents = MenuItem::buildParentOptions();

        return view('admin.menus.form', [
            'menu' => new MenuItem,
            'parents' => $parents,
        ]);
    }

    /**
     * Store a newly created menu item.
     */
    public function store(Request $request)
    {
        $data = $this->validateMenu($request);

        DB::beginTransaction();

        try {

            MenuItem::create($data);

            DB::commit();

            return redirect()
                ->route('menus.index')
                ->with('success', 'Menu item created successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            SystemLogger::log(
                'Menu creation failed',
                'error',
                'menus.store',
                [
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to create menu item.');
        }
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(MenuItem $menu)
    {
        $parents = MenuItem::buildParentOptions($menu);

        return view('admin.menus.form', compact('menu', 'parents'));
    }

    /**
     * Update the specified menu item.
     */
    public function update(Request $request, MenuItem $menu)
    {
        $data = $this->validateMenu($request, $menu);

        DB::beginTransaction();

        try {

            $menu->update($data);

            DB::commit();

            return redirect()
                ->route('menus.index')
                ->with('success', 'Menu item updated successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            SystemLogger::log(
                'Menu update failed',
                'error',
                'menus.update',
                [
                    'menu_id' => $menu->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to update menu item.');
        }
    }

    /**
     * Remove the specified menu item.
     *
     * The menu_items foreign key uses nullOnDelete, so immediate children of
     * a deleted item are promoted to the top level rather than deleted.
     */
    public function destroy(MenuItem $menu)
    {
        DB::beginTransaction();

        try {

            $menu->delete();

            DB::commit();

            return redirect()
                ->route('menus.index')
                ->with('success', 'Menu item deleted successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            SystemLogger::log(
                'Menu deletion failed',
                'error',
                'menus.destroy',
                [
                    'menu_id' => $menu->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to delete menu item.');
        }
    }

    /**
     * Validation rules for menu items.
     */
    protected function validateMenu(Request $request, ?MenuItem $menu = null): array
    {
        $parentRules = ['nullable', 'exists:menu_items,id'];

        if ($menu && $request->filled('parent_id')) {
            $forbidden = array_merge([$menu->id], $menu->getDescendantIds());
            $parentRules[] = Rule::notIn($forbidden);
        }

        return $request->validate(
            [
                'title_en' => 'required|string|max:255',
                'title_es' => 'nullable|string|max:255',
                'link' => 'nullable|string|max:255',
                'order' => 'nullable|integer',
                'parent_id' => $parentRules,
            ],
            [
                'parent_id.not_in' => 'The selected parent would create an invalid menu hierarchy.',
            ]
        );
    }
}
