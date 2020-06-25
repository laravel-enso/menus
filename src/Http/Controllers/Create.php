<?php

namespace LaravelEnso\Menus\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\Forms\Builders\MenuForm;

class Create extends Controller
{
    public function __invoke(MenuForm $form)
    {
        return ['form' => $form->create()];
    }
}
