<?php

namespace LaravelEnso\MenuManager\app\Classes;

use Illuminate\Support\Collection;

class CurrentMenuDetector
{
    private $menus;
    private $path;
    public $menu;

    public function __construct(Collection $menus)
    {
        $this->menus = $menus;
        $this->path = request()->path();
        $this->menu = $this->detect();
    }

    public function get()
    {
        return $this->menu;
    }

    private function detect()
    {
        $currentMenu = $this->attemptMenuMatching();

        if ($currentMenu) {
            return $currentMenu;
        }

        $this->trimPathEndingSegment();

        return (is_null($this->path)) ? null : $this->detect();
    }

    private function attemptMenuMatching()
    {
        $index = $this->menus->search(function ($menu) {
            return $menu->link === $this->path;
        });

        return $index !== false ? $this->menus[$index] : null;
    }

    private function trimPathEndingSegment()
    {
        $separatorIndex = strrpos($this->path, '/');
        $this->path = $separatorIndex !== false ? substr($this->path, 0, $separatorIndex) : null;
    }
}
