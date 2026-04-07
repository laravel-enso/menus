<?php

namespace LaravelEnso\Menus\State;

use LaravelEnso\Core\Contracts\ProvidesState;
use LaravelEnso\Menus\Http\Resources\Menu;
use LaravelEnso\Menus\Services\TreeBuilder;

class Menus implements ProvidesState
{
    public function store(): string
    {
        return 'menu';
    }

    public function state(): array
    {
        return Menu::collection((new TreeBuilder())->handle())->resolve();
    }
}
