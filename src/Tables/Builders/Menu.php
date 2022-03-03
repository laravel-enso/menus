<?php

namespace LaravelEnso\Menus\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Menus\Models\Menu as Model;
use LaravelEnso\Tables\Contracts\Table;

class Menu implements Table
{
    private const TemplatePath = __DIR__.'/../Templates/menus.json';

    public function query(): Builder
    {
        return Model::selectRaw('
            menus.id, menus.name, menus.icon, menus.has_children, menus.order_index,
            parent_menus.name as parent, permissions.name as route, menus.created_at
        ')->leftJoin('permissions', 'menus.permission_id', '=', 'permissions.id')
            ->leftJoin('menus as parent_menus', 'menus.parent_id', '=', 'parent_menus.id');
    }

    public function templatePath(): string
    {
        return self::TemplatePath;
    }
}
