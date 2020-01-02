<?php

namespace LaravelEnso\Menus\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\App\Models\Menu;

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
