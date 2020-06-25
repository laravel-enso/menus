<?php

namespace LaravelEnso\Menus\Forms\Builders;

use LaravelEnso\Forms\Services\Form;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Permissions\Models\Permission;

class MenuForm
{
    protected const FormPath = __DIR__.'/../Templates/menu.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = (new Form(static::FormPath))
            ->options('parent_id', Menu::isParent()->get(['id', 'name']))
            ->options('permission_id', Permission::get(['id', 'name']));
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(Menu $menu)
    {
        return $this->form->edit($menu);
    }
}
