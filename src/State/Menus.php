<?php

namespace LaravelEnso\Menus\State;

use LaravelEnso\Core\Contracts\ProvidesState;
use LaravelEnso\Menus\Http\Resources\Menu;
use LaravelEnso\Menus\Services\TreeBuilder;

class Menus implements ProvidesState
{
    public function mutation(): string
    {
        return 'menu/set';
    }

    public function state(): mixed
    {
        return Menu::collection((new TreeBuilder())->handle());
    }
}
