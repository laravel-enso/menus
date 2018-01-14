<?php

namespace LaravelEnso\MenuManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\MenuManager\app\Http\Services\MenuService;
use LaravelEnso\MenuManager\app\Http\Requests\ValidateMenuRequest;

class MenuController extends Controller
{
    public function create(MenuService $service)
    {
        return $service->create();
    }

    public function store(ValidateMenuRequest $request, Menu $menu, MenuService $service)
    {
        return $service->store($request, $menu);
    }

    public function edit(Menu $menu, MenuService $service)
    {
        return $service->edit($menu);
    }

    public function update(ValidateMenuRequest $request, Menu $menu, MenuService $service)
    {
        return $service->update($request, $menu);
    }

    public function destroy(Menu $menu, MenuService $service)
    {
        return $service->destroy($menu);
    }
}
