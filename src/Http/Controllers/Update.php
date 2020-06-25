<?php

namespace LaravelEnso\Menus\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\Http\Requests\ValidateMenuRequest;
use LaravelEnso\Menus\Models\Menu;

class Update extends Controller
{
    public function __invoke(ValidateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());

        return ['message' => __('The menu was successfully updated')];
    }
}
