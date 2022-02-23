<?php

namespace LaravelEnso\Menus\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\Forms\Builders\Menu;

class Create extends Controller
{
    public function __invoke(Menu $form)
    {
        return ['form' => $form->create()];
    }
}
