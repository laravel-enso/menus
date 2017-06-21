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

    public function getTableQuery()
    {
        return Menu::select(\DB::raw('menus.id as DT_RowId, menus.name, menus.icon,
            parent_menus.name as parent, menus.link, menus.created_at, menus.updated_at')
        )->leftJoin('menus as parent_menus', 'menus.parent_id', '=', 'parent_menus.id');
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
            flash()->success(__('Menu Created'));
        });

        return redirect('system/menus/'.$menu->id.'/edit');
    }

    public function edit(Menu $menu)
    {
        $hasChildrenOptions = (new IsActiveEnum())->getData();
        $menus = Menu::isParent()->pluck('name', 'id');
        $roles = Role::pluck('name', 'id');
        $menu->roles_list;

        return view('laravel-enso/menumanager::edit', compact('menu', 'hasChildrenOptions', 'menus', 'roles'));
    }

    public function update(Menu $menu)
    {
        \DB::transaction(function () use ($menu) {
            $menu->update($this->request->all());
            $roles = $this->request->has('roles_list') ? $this->request->get('roles_list') : [];
            $menu->roles()->sync($roles);
            flash()->success(__('The Changes have been saved!'));
        });

        return back();
    }

    public function destroy(Menu $menu)
    {
        if ($menu->children_list->count()) {
            throw new \EnsoException(__('Menu Has Children'));
        }

        $menu->delete();

        return ['message' => __('Operation was successfull')];
    }
}
