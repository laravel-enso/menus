<?php

namespace LaravelEnso\MenuManager\app\Classes;

use Illuminate\Support\Collection;
use LaravelEnso\MenuManager\app\Models\Menu;

class MenuBuilder
{
    private $menus;

    public function __construct(Collection $menus)
    {
        $this->menus = $menus;
    }

    public function get()
    {
        return $this->getTree();
    }

    private function getTree(int $parentId = null)
    {
        $menus = collect();

        $this->menus->each(function ($menu) use (&$menus, $parentId) {
            if ($menu->parent_id === $parentId) {
                $menu->name = $menu->name;
                $menus->push($this->getChildren($menu));
            }
        });

        return $menus;
    }

    private function getChildren(Menu $menu)
    {
        $menu->children = $menu->has_children
            ? $this->getTree($menu->id)
            : collect();

        $menu['expanded'] = false;

        return $menu;
    }
}
