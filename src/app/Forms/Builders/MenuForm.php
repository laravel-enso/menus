<?php

namespace LaravelEnso\MenuManager\app\Forms\Builders;

use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\FormBuilder\app\Classes\Form;

class MenuForm
{
    private const FormPath = __DIR__.'/../Templates/menu.json';

    private $form;

    public function __construct()
    {
        $this->form = (new Form(self::FormPath))
            ->options('parent_id', Menu::isParent()->get(['name', 'id']))
            ->options('roleList', Role::get(['name', 'id']));
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(Menu $menu)
    {
        return $this->form
            ->value('roleList', $menu->roleList())
            ->edit($menu);
    }
}
