<?php

namespace LaravelEnso\Menus\app\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use LaravelEnso\Menus\app\Models\Menu;

class TreeBuilder
{
    private $permissions;
    private $menus;

    public function handle()
    {
        return $this->permissions()
            ->menus()
            ->filter()
            ->map()
            ->build();
    }

    private function build(?int $parentId = null)
    {
        return $this->menus
            ->filter(fn($menu) => $menu->parent_id === $parentId)
            ->reduce(fn($tree, $menu) => (
                $tree->push($this->withChildren($menu))
            ), collect());
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
        $this->permissions = Auth::user()
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
            ->filter(fn($menu) => $this->allowed($menu));

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

    private function allowed($menu)
    {
        return $this->permissions->pluck('id')->contains($menu->permission_id)
            || $this->someChildrenAllowed($menu);
    }

    private function someChildrenAllowed($parentMenu)
    {
        return $parentMenu->has_children
            && $this->menus->first(fn($childMenu) => $childMenu->parent_id === $parentMenu->id
                && $this->allowed($childMenu));
    }
}
