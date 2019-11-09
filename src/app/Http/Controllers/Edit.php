<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\app\Forms\Builders\MenuForm;
use LaravelEnso\Menus\app\Models\Menu;

class Edit extends Controller
{
    public function __invoke(Menu $menu, MenuForm $form)
    {
        return ['form' => $form->edit($menu)];
    }
}
