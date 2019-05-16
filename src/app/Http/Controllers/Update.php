<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\app\Models\Menu;
use LaravelEnso\Menus\app\Http\Requests\ValidateMenuUpdate;

class Update extends Controller
{
    public function __invoke(ValidateMenuUpdate $request, Menu $menu)
    {
        $menu->update($request->validated());

        return [
            'message' => __('The menu was successfully updated'),
        ];
    }
}
