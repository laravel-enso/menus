<?php

namespace LaravelEnso\Menus\app\Services;

use App\User;
use Illuminate\Support\Str;
use LaravelEnso\Menus\app\Models\Menu;

class TreeBuilder
{
    private $permissions;
    private $menus;
    private $tree;

    public function handle()
    {
        return $this->permissions()
            ->menus()
            ->filter()
            ->map()
            ->build();
    }

    private function build(int $parentId = null)
    {
        $tree = collect();

        $this->menus->each(function ($menu) use ($tree, $parentId) {
            if ($menu->parent_id === $parentId) {
                $tree->push($this->withChildren($menu));
            }
        });

        return $tree;
    }

    private function withChildren(Menu $menu)
    {
        $menu->children = $menu->has_children
            ? $this->build($menu->id)
            : null;

        $menu['expanded'] = false;

        $menu->route = optional($menu->permission)->name;

        unset($menu->permission);

        return $menu;
    }

    private function permissions()
    {
        $this->permissions = User::first()
            ->role
            ->permissions()
            ->has('menu')
            ->get(['id', 'name']);

        return $this;
    }

    private function menus()
    {
        $this->menus = Menu::with('permission:id,name')
            ->orderBy('order_index')
            ->get(['id', 'parent_id', 'permission_id', 'name', 'icon', 'has_children']);

        return $this;
    }

    private function filter()
    {
        $this->menus = $this->menus
            ->filter(function ($menu) {
                return $this->isAllowed($menu);
            });

        return $this;
    }

    private function map()
    {
        $this->menus = $this->menus
            ->map(function ($menu) {
                if (Str::contains($menu->icon, ' ')) {
                    $menu->icon = explode(' ', $menu->icon);
                }

                return $menu;
            });

        return $this;
    }

    private function isAllowed($menu)
    {
        return $this->permissions->pluck('id')->contains($menu->permission_id)
            || $this->someChildrenAreAllowed($menu);
    }

    private function someChildrenAreAllowed($parentMenu)
    {
        return $parentMenu->has_children
            && $this->menus->first(function ($childMenu) use ($parentMenu) {
                return $childMenu->parent_id === $parentMenu->id
                    && $this->isAllowed($childMenu);
            });
    }
}
