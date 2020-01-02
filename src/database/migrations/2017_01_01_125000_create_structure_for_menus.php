<?php

use LaravelEnso\Migrator\App\Database\Migration;
use LaravelEnso\Permissions\App\Enums\Types;

class CreateStructureForMenus extends Migration
{
    protected $permissions = [
        ['name' => 'system.menus.index', 'description' => 'Menus index', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'system.menus.tableData', 'description' => 'Get table data for menus', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'system.menus.exportExcel', 'description' => 'Export excel for menus', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'system.menus.initTable', 'description' => 'Init table for menus menu', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'system.menus.create', 'description' => 'Create menu', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'system.menus.edit', 'description' => 'Edit menu', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'system.menus.store', 'description' => 'Store newly created menu', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'system.menus.update', 'description' => 'Update edited menu', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'system.menus.destroy', 'description' => 'Delete menu', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'system.menus.organize', 'description' => 'Organize menus', 'type' => Types::Write, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Menus', 'icon' => 'list', 'route' => 'system.menus.index', 'order_index' => 999, 'has_children' => false,
    ];

    protected $parentMenu = 'System';
}
