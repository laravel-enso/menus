<?php

namespace LaravelEnso\MenuManager\app\DataTable;

use LaravelEnso\DataTable\app\Classes\TableStructure;

class MenusTableStructure extends TableStructure
{
    public function __construct()
    {
        $this->data = [
            'tableName'     => __('Menus'),
            'crtNo'         => __('#'),
            'actionButtons' => __('Actions'),
            'notSearchable' => [2, 4, 5],
            'render'        => [1],
            'headerAlign'   => 'center',
            'bodyAlign'     => 'center',
            'columns'       => [
                0 => [
                    'label' => __('Name'),
                    'data'  => 'name',
                    'name'  => 'menus.name',
                ],
                1 => [
                    'label' => __('Icon'),
                    'data'  => 'icon',
                    'name'  => 'menus.icon',
                ],
                2 => [
                    'label' => __('Parent'),
                    'data'  => 'parent',
                    'name'  => 'parent_menus.name',
                ],
                3 => [
                    'label' => __('Link'),
                    'data'  => 'link',
                    'name'  => 'menus.link',
                ],
                4 => [
                    'label' => __('Created At'),
                    'data'  => 'created_at',
                    'name'  => 'menus.created_at',
                ],
                5 => [
                    'label' => __('Updated At'),
                    'data'  => 'updated_at',
                    'name'  => 'menus.updated_at',
                ],
            ],
        ];
    }
}
