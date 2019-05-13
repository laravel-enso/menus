<?php

namespace LaravelEnso\MenuManager\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\MenuManager\app\Http\Requests\ValidateMenuRequest;

class Update extends Controller
{
    public function __invoke(ValidateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());
      
        return [
            'message' => __('The menu was successfully updated'),
        ];
    }
}
