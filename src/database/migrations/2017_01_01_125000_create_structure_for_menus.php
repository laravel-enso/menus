<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForMenus extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'system.menus', 'description' => 'Menus permissions group',
    ];

    protected $permissions = [
        ['name' => 'system.menus.getTableData', 'description' => 'Get table data for menus', 'type' => 0, 'default' => false],
        ['name' => 'system.menus.exportExcel', 'description' => 'Export excel for menus', 'type' => 0, 'default' => false],
        ['name' => 'system.menus.initTable', 'description' => 'Init table for menus menu', 'type' => 0, 'default' => false],
        ['name' => 'system.menus.create', 'description' => 'Create menu', 'type' => 1, 'default' => false],
        ['name' => 'system.menus.edit', 'description' => 'Edit menu', 'type' => 1, 'default' => false],
        ['name' => 'system.menus.store', 'description' => 'Store newly created menu', 'type' => 1, 'default' => false],
        ['name' => 'system.menus.update', 'description' => 'Update edited menu', 'type' => 1, 'default' => false],
        ['name' => 'system.menus.destroy', 'description' => 'Delete menu', 'type' => 1, 'default' => false],
    ];

    protected $menu = [
        'name' => 'Menus', 'icon' => 'fa fa-fw fa-list', 'link' => 'system.menus.index', 'has_children' => false,
    ];

    protected $parentMenu = 'System';
}
