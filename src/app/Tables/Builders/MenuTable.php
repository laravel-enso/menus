<?php

namespace LaravelEnso\MenuManager\app\Tables\Builders;

use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\VueDatatable\app\Classes\Table;

class MenuTable extends Table
{
    protected $templatePath = __DIR__.'/../Templates/menus.json';

    public function query()
    {
        return Menu::select(\DB::raw('
            menus.id as "dtRowId", menus.name, menus.icon, menus.has_children,
            menus.order_index, parent_menus.name as parent, permissions.name as route, menus.created_at
        '))->leftJoin('permissions', 'menus.permission_id', '=', 'permissions.id')
        ->leftJoin('menus as parent_menus', 'menus.parent_id', '=', 'parent_menus.id');
    }
}
