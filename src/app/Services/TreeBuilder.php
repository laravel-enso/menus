<?php

namespace LaravelEnso\Menus\App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use LaravelEnso\Menus\App\Models\Menu;

class TreeBuilder
{
    private Collection $permissions;
    private Collection $menus;

    public function handle()
    {
        return $this->permissions()
            ->menus()
            ->filter()
            ->map()
            ->build();
    }

    protected function build(?int $parentId = null): Collection
    {
        return $this->menus
            ->filter(fn ($menu) => $menu->parent_id === $parentId)
            ->reduce(fn ($tree, $menu) => $tree->push($this->withChildren($menu)
        ), new Collection());
    }

    protected function withChildren(Menu $menu): Menu
    {
        $menu->children = $menu->has_children
            ? $this->build($menu->id)
            : null;

        $menu['expanded'] = false;

        $menu->route = optional($menu->permission)->name;

        unset($menu->permission);

        return $menu;
    }

    protected function permissions(): self
    {
        $this->permissions = Auth::user()->role
            ->permissions()
            ->has('menu')
            ->get(['id', 'name']);

        return $this;
    }

    protected function menus(): self
    {
        $this->menus = Menu::with('permission:id,name')
            ->orderBy('order_index')
            ->get(['id', 'parent_id', 'permission_id', 'name', 'icon', 'has_children']);

        return $this;
    }

    protected function filter(): self
    {
        $this->menus = $this->menus->filter(fn ($menu) => $this->allowed($menu));

        return $this;
    }

    protected function map(): self
    {
        $this->menus = $this->menus->map(fn ($menu) => $this->computeIcon($menu));

        return $this;
    }

    protected function computeIcon(Menu $menu): Menu
    {
        if (Str::contains($menu->icon, ' ')) {
            $menu->icon = explode(' ', $menu->icon);
        }

        return $menu;
    }

    protected function allowed($menu): bool
    {
        return $this->permissions->pluck('id')->contains($menu->permission_id)
            || $menu->has_children && $this->someChildrenAllowed($menu);
    }

    protected function someChildrenAllowed($parent): bool
    {
        return $this->menus->some(
            fn ($child) => $child->parent_id === $parent->id && $this->allowed($child)
        );
    }
}
