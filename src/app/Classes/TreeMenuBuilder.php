<?php

namespace LaravelEnso\MenuManager\app\Classes;

use Illuminate\Support\Collection;
use LaravelEnso\MenuManager\app\Models\Menu;

class TreeMenuBuilder
{
    private $tree;
    private $menus;

    public function __construct(Collection $menus)
    {
        $this->menus = $menus;
        $this->tree = $this->getTree();
    }

    public function get()
    {
        return $this->tree;
    }

    private function getTree(int $parentId = null)
    {
        $menus = collect();

        $this->menus->each(function ($menu) use (&$menus, $parentId) {
            if ($menu->parent_id !== $parentId) {
                return true;
            }

            $menu->name = __($menu->name);
            $menus->push($this->getChildren($menu));
        });

        return $menus;
    }

    private function getChildren(Menu $menu)
    {
        $menu->children = $menu->has_children ? $this->getTree($menu->id) : [];
        $menu['unique_id'] = $menu['id'];
        unset($menu['id']);

        return $menu;
    }
}
