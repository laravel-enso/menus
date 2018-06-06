<?php

namespace LaravelEnso\MenuManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\MenuManager\app\Forms\Builders\MenuForm;
use LaravelEnso\MenuManager\app\Http\Requests\ValidateMenuRequest;

class MenuController extends Controller
{
    public function create(MenuForm $form)
    {
        return ['form' => $form->create()];
    }

    public function store(ValidateMenuRequest $request, Menu $menu)
    {
        $menu = $menu->storeWithRoles(
            $request->all(),
            $request->get('roleList')
        );

        return [
            'message' => __('The menu was created!'),
            'redirect' => 'system.menus.edit',
            'id' => $menu->id,
        ];
    }

    public function edit(Menu $menu, MenuForm $form)
    {
        return ['form' => $form->edit($menu)];
    }

    public function update(ValidateMenuRequest $request, Menu $menu)
    {
        $menu->updateWithRoles(
            $request->all(),
            $request->get('roleList')
        );

        return [
            'message' => __('The menu was successfully updated')
        ];
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return [
            'message' => __('The menu was successfully deleted'),
            'redirect' => 'system.menus.index',
        ];
    }
}
