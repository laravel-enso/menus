<?php

namespace LaravelEnso\MenuManager\app\Classes;

use LaravelEnso\MenuManager\app\Models\Menu;

class MenuTree
{
    private $permissions;
    private $menus;

    public function get()
    {
        return $this->setPermissions()
            ->getMenus()
            ->filter()
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

    private function setPermissions()
    {
        $this->permissions = auth()->user()
            ->role
            ->permissions()
            ->has('menu')
            ->get(['id', 'name']);

        return $this;
    }

    private function getMenus()
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
