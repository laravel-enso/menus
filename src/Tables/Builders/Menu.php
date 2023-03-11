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
        $select = [
            'id', 'parent_id', 'permission_id', 'name', 'icon',
            'has_children', 'order_index', 'created_at',
        ];

        return Model::query()
            ->with('parent:id,name', 'permission:id,name')
            ->select($select);
    }

    public function templatePath(): string
    {
        return self::TemplatePath;
    }
}
