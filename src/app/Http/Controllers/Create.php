<?php

namespace LaravelEnso\Menus\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\App\Forms\Builders\MenuForm;

class Create extends Controller
{
    public function __invoke(MenuForm $form)
    {
        return ['form' => $form->create()];
    }
}
