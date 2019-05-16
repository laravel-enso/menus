<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Menus\app\Services\Organizer;

class Organize extends Controller
{
    public function __invoke(Request $request)
    {
        (new Organizer($request->get('menus')))->handle();

        return [
            'message' => __('The menu order has been sucessfully updated'),
        ];
    }
}
