<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\app\Models\Menu;
use LaravelEnso\Menus\app\Http\Requests\ValidateMenuRequest;

class Update extends Controller
{
    public function __invoke(ValidateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());

        return ['message' => __('The menu was successfully updated')];
    }
}
