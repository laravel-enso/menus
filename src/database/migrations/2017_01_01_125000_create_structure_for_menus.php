<?php

use LaravelEnso\Migrator\app\Database\Migration;

class CreateStructureForMenus extends Migration
{
    protected $permissions = [
        ['name' => 'system.menus.index', 'description' => 'Menus index', 'type' => 0, 'is_default' => false],
        ['name' => 'system.menus.tableData', 'description' => 'Get table data for menus', 'type' => 0, 'is_default' => false],
        ['name' => 'system.menus.exportExcel', 'description' => 'Export excel for menus', 'type' => 0, 'is_default' => false],
        ['name' => 'system.menus.initTable', 'description' => 'Init table for menus menu', 'type' => 0, 'is_default' => false],
        ['name' => 'system.menus.create', 'description' => 'Create menu', 'type' => 1, 'is_default' => false],
        ['name' => 'system.menus.edit', 'description' => 'Edit menu', 'type' => 1, 'is_default' => false],
        ['name' => 'system.menus.store', 'description' => 'Store newly created menu', 'type' => 1, 'is_default' => false],
        ['name' => 'system.menus.update', 'description' => 'Update edited menu', 'type' => 1, 'is_default' => false],
        ['name' => 'system.menus.destroy', 'description' => 'Delete menu', 'type' => 1, 'is_default' => false],
        ['name' => 'system.menus.organize', 'description' => 'Organize menus', 'type' => 1, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Menus', 'icon' => 'list', 'route' => 'system.menus.index', 'order_index' => 999, 'has_children' => false,
    ];

    protected $parentMenu = 'System';
}
