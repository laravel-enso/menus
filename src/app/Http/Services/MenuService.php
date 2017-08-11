<?php

namespace LaravelEnso\MenuManager\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\FormBuilder\app\Classes\FormBuilder;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;

class MenuService
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create()
    {
        $form = (new FormBuilder(__DIR__.'/../../Forms/menu.json'))
            ->setAction('POST')
            ->setTitle('Create Menu')
            ->setUrl('/system/menus')
            ->setSelectOptions('parent_id', Menu::isParent()->pluck('name', 'id'))
            ->setSelectOptions('roleList', Role::pluck('name', 'id'))
            ->getData();

        return view('laravel-enso/menumanager::create', compact('form'));
    }

    public function store(Menu $menu)
    {
        \DB::transaction(function () use (&$menu) {
            $menu = $menu->create($this->request->all());
            $roles = $this->request->has('roleList')
                ? $this->request->get('roleList')
                : [];

            $menu->roles()->sync($roles);
        });

        return [
            'message'  => __('The menu was created!'),
            'redirect' => '/system/menus/'.$menu->id.'/edit',
        ];
    }

    public function edit(Menu $menu)
    {
        $menu->append(['roleList']);

        $form = (new FormBuilder(__DIR__.'/../../Forms/menu.json', $menu))
            ->setAction('PATCH')
            ->setTitle('Edit Menu')
            ->setUrl('/system/menus/'.$menu->id)
            ->setSelectOptions('parent_id', Menu::isParent()->pluck('name', 'id'))
            ->setSelectOptions('roleList', Role::pluck('name', 'id'))
            ->getData();

        return view('laravel-enso/menumanager::edit', compact('form'));
    }

    public function update(Menu $menu)
    {
        \DB::transaction(function () use ($menu) {
            $menu->update($this->request->all());
            $roles = $this->request->has('roleList')
                ? $this->request->get('roleList')
                : [];

            $menu->roles()->sync($roles);
        });

        return [
            'message' => __(config('labels.savedChanges')),
        ];
    }

    public function destroy(Menu $menu)
    {
        if ($menu->children_list->count()) {
            throw new \EnsoException(__('Menu Has Children'));
        }

        $menu->delete();

        return ['message' => __(config('labels.successfulOperation'))];
    }
}
