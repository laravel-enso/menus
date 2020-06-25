<?php

namespace LaravelEnso\Menus\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\Forms\Builders\MenuForm;
use LaravelEnso\Menus\Models\Menu;

class Edit extends Controller
{
    public function __invoke(Menu $menu, MenuForm $form)
    {
        return ['form' => $form->edit($menu)];
    }
}
