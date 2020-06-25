<?php

namespace LaravelEnso\Menus\Services;

use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Menus\Models\Menu;

class Organizer
{
    private Obj $menus;

    public function __construct(array $menus)
    {
        $this->menus = new Obj($menus);
    }

    public function handle(): void
    {
        $this->organize($this->menus);
    }

    private function organize(Obj $menus): void
    {
        $menus->each(fn ($menu, $index) => $this->reorder($menu, $index));
    }

    private function reorder(Obj $menu, int $index): void
    {
        Menu::find($menu->get('id'))
            ->update(['order_index' => ($index + 1) * 10]);

        if ($menu->get('has_children')) {
            $this->organize($menu->get('children'));
        }
    }
}
