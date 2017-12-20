<?php

namespace LaravelEnso\MenuManager\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\FormBuilder\app\Classes\FormBuilder;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class MenuService
{
    public function create()
    {
        $form = (new FormBuilder(__DIR__.'/../../Forms/menu.json'))
            ->setMethod('POST')
            ->setTitle('Create Menu')
            ->setSelectOptions('parent_id', Menu::isParent()->pluck('name', 'id'))
            ->setSelectOptions('roleList', Role::pluck('name', 'id'))
            ->getData();

        return compact('form');
    }

    public function store(Request $request, Menu $menu)
    {
        \DB::transaction(function () use ($request, &$menu) {
            $menu = $menu->create($request->all());
            $menu->roles()->sync($request->get('roleList'));
        });

        return [
            'message' => __('The menu was created!'),
            'redirect' => 'system.menus.edit',
            'id' => $menu->id,
        ];
    }

    public function edit(Menu $menu)
    {
        $menu->append(['roleList']);

        $form = (new FormBuilder(__DIR__.'/../../Forms/menu.json', $menu))
            ->setMethod('PATCH')
            ->setTitle('Edit Menu')
            ->setSelectOptions('parent_id', Menu::isParent()->pluck('name', 'id'))
            ->setSelectOptions('roleList', Role::pluck('name', 'id'))
            ->getData();

        return compact('form');
    }

    public function update(Request $request, Menu $menu)
    {
        \DB::transaction(function () use ($request, $menu) {
            $menu->update($request->all());
            $menu->roles()->sync($request->get('roleList'));
        });

        return [
            'message' => __(config('enso.labels.savedChanges')),
        ];
    }

    public function destroy(Menu $menu)
    {
        if ($menu->children_list->count()) {
            throw new ConflictHttpException(__('Menu Has Children'));
        }

        $menu->delete();

        return [
            'message' => __(config('enso.labels.successfulOperation')),
            'redirect' => 'system.menus.index',
        ];
    }
}
