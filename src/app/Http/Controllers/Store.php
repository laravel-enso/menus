<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\app\Models\Menu;
use LaravelEnso\Menus\app\Http\Requests\ValidateMenuStore;

class Store extends Controller
{
    public function __invoke(ValidateMenuStore $request, Menu $menu)
    {
        tap($menu)->fill($request->validated())
            ->save();

        return [
            'message' => __('The menu was created!'),
            'redirect' => 'system.menus.edit',
            'param' => ['menu' => $menu->id],
        ];
    }
}
