<?php

namespace LaravelEnso\MenuManager\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\MenuManager\app\Forms\Builders\MenuForm;

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
