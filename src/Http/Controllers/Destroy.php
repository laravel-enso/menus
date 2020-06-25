<?php

namespace LaravelEnso\Menus\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\Models\Menu;

class Destroy extends Controller
{
    public function __invoke(Menu $menu)
    {
        $menu->delete();

        return [
            'message' => __('The menu was successfully deleted'),
            'redirect' => 'system.menus.index',
        ];
    }
}
