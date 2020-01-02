<?php

namespace LaravelEnso\Menus\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Menus\App\Services\Organizer;

class Organize extends Controller
{
    public function __invoke(Request $request)
    {
        (new Organizer($request->get('menus')))->handle();

        return ['message' => __('The menu order has been sucessfully updated')];
    }
}
