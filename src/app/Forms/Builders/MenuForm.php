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
        $this->form = new Form(self::FormPath);
    }

    public function create()
    {
        return $this->form
            ->options('parent_id', Menu::isParent()->pluck('name', 'id'))
            ->options('roleList', Role::pluck('name', 'id'))
            ->create();
    }

    public function edit(Menu $menu)
    {
        $menu->append(['roleList']);

        return $this->form
            ->options('parent_id', Menu::isParent()->pluck('name', 'id'))
            ->options('roleList', Role::pluck('name', 'id'))
            ->edit($menu);
    }
}
