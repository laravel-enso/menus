<?php

namespace LaravelEnso\MenuManager\app\Classes;

use Illuminate\Support\Collection;
use LaravelEnso\MenuManager\app\Models\Menu;

class MenuGenerator
{
    private $menus;
    private $activeMenuIds;
    private $html;

    public function __construct(Collection $menus)
    {
        $this->menus = $menus;
        $this->activeMenuIds = $this->getActiveMenuIds();
        $this->generate();
    }

    public function render()
    {
        return $this->html;
    }

    private function getActiveMenuIds()
    {
        $ids = collect();
        $currentMenu = (new CurrentMenuDetector($this->menus))->get();

        while ($currentMenu) {
            $ids->push($currentMenu->id);
            $currentMenu = $currentMenu->parent;
        }

        return $ids;
    }

    private function generate()
    {
        $this->html = '<aside class="main-sidebar"><section class="sidebar"><ul class="sidebar-menu"><li class="header">'.__('Main Menu').'</li>';
        $this->buildCurrentLevel();
        $this->html .= '</ul></section></aside>';
    }

    private function buildCurrentLevel(int $parentId = null)
    {
        $this->menus->each(function ($menu) use ($parentId) {
            if ($menu->parent_id !== $parentId) {
                return true;
            }

            $class = $this->isActive($menu) ? 'active' : '';

            return ($menu->has_children)
                ? $this->appendParent($menu, $class)
                : $this->append($menu, $class);
        });
    }

    private function isActive(Menu $menu)
    {
        return $this->activeMenuIds->contains($menu->id);
    }

    private function appendParent(Menu $menu, string $class)
    {
        $this->html .= '<li class="'.$class.'">';
        $icon = '<i class="fa fa-angle-left pull-right"></i>';
        $this->appendLabel($menu, $icon);
        $this->html .= '<ul class="treeview-menu">';
        $this->buildCurrentLevel($menu->id);
        $this->html .= '</ul></li>';
    }

    private function append(Menu $menu, string $class)
    {
        $this->html .= '<li class ="'.$class.'">';
        $this->appendLabel($menu);
        $this->html .= '</li>';
    }

    private function appendLabel(Menu $menu, string $angle = '')
    {
        $link = $menu->has_children ? '#' : ('/'.$menu->link);
        $this->html .= "<a href = '".$link."'><i class = '".$menu->icon."'></i><span>".__($menu->name)."</span>$angle</a>";
    }
}
