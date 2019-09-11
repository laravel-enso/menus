<?php

namespace LaravelEnso\Menus\app\Tables\Builders;

use LaravelEnso\Menus\app\Models\Menu;
use LaravelEnso\Tables\app\Services\Table;

class MenuTable extends Table
{
    protected $templatePath = __DIR__.'/../Templates/menus.json';

    public function query()
    {
        return Menu::selectRaw('
            menus.id, menus.name, menus.icon, menus.has_children, menus.order_index,
            parent_menus.name as parent, permissions.name as route, menus.created_at
        ')->leftJoin('permissions', 'menus.permission_id', '=', 'permissions.id')
        ->leftJoin('menus as parent_menus', 'menus.parent_id', '=', 'parent_menus.id');
    }
}
