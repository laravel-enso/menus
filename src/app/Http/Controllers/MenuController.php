<?php

namespace LaravelEnso\MenuManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\MenuManager\app\Classes\TreeMenuBuilder;
use LaravelEnso\MenuManager\app\DataTable\MenusTableStructure;
use LaravelEnso\Core\app\Enums\IsActiveEnum;
use LaravelEnso\MenuManager\app\Http\Requests\ValidateMenuRequest;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\Core\app\Models\Role;
use LaravelEnso\DataTable\app\Traits\DataTable;

class MenuController extends Controller
{
    use DataTable;

    protected $tableStructureClass = MenusTableStructure::class;

    public function getTableQuery()
    {
        $query = Menu::select(\DB::raw('menus.id as DT_RowId, menus.name, menus.icon,
            parent_menus.name as parent, menus.link, menus.created_at, menus.updated_at')
        )->leftJoin('menus as parent_menus', 'menus.parent_id', '=', 'parent_menus.id');

        return $query;
    }

    public function index()
    {
        return view('laravel-enso/menumanager::index');
    }

    public function create()
    {
        $isActiveEnum = new IsActiveEnum();
        $hasChildrenOptions = $isActiveEnum->getData();
        $menus = Menu::whereHasChildren(1)->pluck('name', 'id');

        return view('laravel-enso/menumanager::create', compact('hasChildrenOptions', 'menus'));
    }

    public function store(ValidateMenuRequest $request, Menu $menu)
    {
        $menu->fill($request->all());

        \DB::transaction(function () use ($request, $menu) {
            $menu->save();
            $menu->roles()->attach(1); // admin

            flash()->success(__('Menu Created'));
        });

        return redirect('system/menus/'.$menu->id.'/edit');
    }

    public function edit(Menu $menu)
    {
        $isActiveEnum = new IsActiveEnum();
        $hasChildrenOptions = $isActiveEnum->getData();
        $menus = Menu::whereHasChildren(true)->pluck('name', 'id');
        $roles = Role::all()->pluck('name', 'id');
        $menu->roles_list;

        return view('laravel-enso/menumanager::edit', compact('menu', 'hasChildrenOptions', 'menus', 'roles'));
    }

    public function update(ValidateMenuRequest $request, Menu $menu)
    {
        \DB::transaction(function () use ($request, $menu) {
            $menu->fill($request->all());
            $menu->save();
            $roles = $request->roles_list ? $request->roles_list : [];
            $menu->roles()->sync($roles);

            flash()->success(__('The Changes have been saved!'));
        });

        return back();
    }

    public function destroy(Menu $menu)
    {
        if ($menu->children_list->count()) {
            return [
                'level'   => 'error',
                'message' => __('Menu Has Children'),
            ];
        }

        $menu->delete();

        return [
            'level'   => 'success',
            'message' => __('Operation was successfull'),
        ];
    }

    public function reorder()
    {
        $menus = Menu::orderBy('order')->get();
        $treeMenu = (new TreeMenuBuilder($menus))->get();

        return view('laravel-enso/menumanager::reorder', compact('treeMenu'));
    }

    public function setOrder()
    {
        \DB::transaction(function () {
            $menus = request('menus');
            $this->updateMenu($menus, null);
        });

        flash()->success(__('The Changes have been saved!'));
    }

    private function updateMenu($menus, $id)
    {
        $order = 0;

        foreach ($menus as $element) {
            $order++;
            $menu = Menu::find($element['unique_id']);
            $menu->parent_id = $id;
            $menu->has_children = false;

            if (count($element['children'])) {
                $menu->has_children = true;
                $this->updateMenu($element['children'], $element['unique_id']);
            }

            $menu->order = $order;
            $menu->save();
        }
    }
}
