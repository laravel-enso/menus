<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\app\Models\Menu;
use LaravelEnso\Menus\app\Http\Requests\ValidateMenuCreate;

class Store extends Controller
{
    public function __invoke(ValidateMenuCreate $request, Menu $menu)
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
