<?php

namespace LaravelEnso\MenuManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelEnso\MenuManager\app\Http\Requests\ValidateMenuRequest;
use LaravelEnso\MenuManager\app\Http\Services\MenuService;
use LaravelEnso\MenuManager\app\Models\Menu;

class MenuController extends Controller
{
    private $menus;

    public function __construct(Request $request)
    {
        $this->menus = new MenuService($request);
    }

    public function index()
    {
        return view('laravel-enso/menumanager::index');
    }

    public function create()
    {
        return $this->menus->create();
    }

    public function store(ValidateMenuRequest $request, Menu $menu)
    {
        return $this->menus->store($menu);
    }

    public function edit(Menu $menu)
    {
        return $this->menus->edit($menu);
    }

    public function update(ValidateMenuRequest $request, Menu $menu)
    {
        return $this->menus->update($menu);
    }

    public function destroy(Menu $menu)
    {
        return $this->menus->destroy($menu);
    }
}
