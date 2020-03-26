<?php

namespace LaravelEnso\Menus\App\Forms\Builders;

use LaravelEnso\Forms\App\Services\Form;
use LaravelEnso\Menus\App\Models\Menu;
use LaravelEnso\Permissions\App\Models\Permission;

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
