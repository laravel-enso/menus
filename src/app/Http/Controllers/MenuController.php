<?php

namespace LaravelEnso\MenuManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\MenuManager\app\Http\Requests\ValidateMenuRequest;
use LaravelEnso\MenuManager\app\Http\Services\MenuService;
use LaravelEnso\MenuManager\app\Models\Menu;

class MenuController extends Controller
{
    private $service;

    public function __construct(MenuService $service)
    {
        $this->service = $service;
    }

    public function create()
    {
        return $this->service->create();
    }

    public function store(ValidateMenuRequest $request, Menu $menu)
    {
        return $this->service->store($request, $menu);
    }

    public function edit(Menu $menu)
    {
        return $this->service->edit($menu);
    }

    public function update(ValidateMenuRequest $request, Menu $menu)
    {
        return $this->service->update($request, $menu);
    }

    public function destroy(Menu $menu)
    {
        return $this->service->destroy($menu);
    }
}
