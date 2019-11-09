<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\app\Http\Requests\ValidateMenuRequest;
use LaravelEnso\Menus\app\Models\Menu;

class Store extends Controller
{
    public function __invoke(ValidateMenuRequest $request, Menu $menu)
    {
        $menu->fill($request->validated())->save();

        return [
            'message' => __('The menu was created!'),
            'redirect' => 'system.menus.edit',
            'param' => ['menu' => $menu->id],
        ];
    }
}
