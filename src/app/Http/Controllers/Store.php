<?php

namespace LaravelEnso\MenuManager\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\MenuManager\app\Http\Requests\ValidateMenuRequest;

class Store extends Controller
{
    public function __invoke(ValidateMenuRequest $request, Menu $menu)
    {
        tap($menu)
            ->fill($request->validated())
            ->save();

        return [
            'message' => __('The menu was created!'),
            'redirect' => 'system.menus.edit',
            'param' => ['menu' => $menu->id],
        ];
    }
}
