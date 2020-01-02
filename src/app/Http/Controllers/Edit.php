<?php

namespace LaravelEnso\Menus\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\App\Forms\Builders\MenuForm;
use LaravelEnso\Menus\App\Models\Menu;

class Edit extends Controller
{
    public function __invoke(Menu $menu, MenuForm $form)
    {
        return ['form' => $form->edit($menu)];
    }
}
