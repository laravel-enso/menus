<?php

namespace LaravelEnso\MenuManager\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\Core\app\Enums\IsActiveEnum;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\RoleManager\app\Models\Role;

class MenuService
{
    private const AdminRoleId = 1;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return view('laravel-enso/menumanager::index');
    }

    public function create()
    {
        $hasChildrenOptions = (new IsActiveEnum())->getData();
        $menus = Menu::isParent()->pluck('name', 'id');

        return view('laravel-enso/menumanager::create', compact('hasChildrenOptions', 'menus'));
    }

    public function store(Menu $menu)
    {
        \DB::transaction(function () use (&$menu) {
            $menu = $menu->create($this->request->all());
            $menu->roles()->attach(self::AdminRoleId);
        });

        flash()->success(__('Menu Created'));

        return redirect('system/menus/'.$menu->id.'/edit');
    }

    public function edit(Menu $menu)
    {
        $hasChildrenOptions = (new IsActiveEnum())->getData();
        $menus = Menu::isParent()->pluck('name', 'id');
        $roles = Role::pluck('name', 'id');
        $menu->roleList;

        return view('laravel-enso/menumanager::edit', compact('menu', 'hasChildrenOptions', 'menus', 'roles'));
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

        flash()->success(__(config('labels.savedChanges')));

        return back();
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
