<?php

namespace LaravelEnso\Menus\app\Services;

use LaravelEnso\Menus\app\Models\Menu;

class Organizer
{
    private $menus;

    public function __construct(array $menus)
    {
        $this->menus = $menus;
    }

    public function handle()
    {
        $this->organize($this->menus);
    }

    private function organize($menus)
    {
        collect($menus)->each(function ($menu, $key) {
            Menu::find($menu['id'])
                ->update(['order_index' => ($key + 1) * 10]);
            if ($menu['has_children']) {
                $this->organize($menu['children']);
            }
        });
    }
}
