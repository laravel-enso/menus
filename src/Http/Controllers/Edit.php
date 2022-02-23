<?php

namespace LaravelEnso\Menus\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\Forms\Builders\Menu as Form;
use LaravelEnso\Menus\Models\Menu;

class Edit extends Controller
{
    public function __invoke(Menu $menu, Form $form)
    {
        return ['form' => $form->edit($menu)];
    }
}
