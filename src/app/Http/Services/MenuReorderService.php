<?php

namespace LaravelEnso\MenuManager\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\MenuManager\app\Classes\TreeMenuBuilder;
use LaravelEnso\MenuManager\app\Models\Menu;

class MenuReorderService
{
	private $request;

	public function __construct(Request $request)
    {
        $this->request = $request;
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
            $menus = $this->request->menus;
            $this->updateOrder($menus, null);
        });

        flash()->success(__('The Changes have been saved!'));
    }

    private function updateOrder(array $menus, int $id = null)
    {
        foreach ($menus as $order => $element) {
            $menu = Menu::find($element['unique_id']);
            $menu->parent_id = $id;
            $menu->has_children = !empty($element['children']);

            if ($menu->has_children) {
                $this->updateOrder($element['children'], $element['unique_id']);
            }

            $menu->order = $order;
            $menu->save();
        }
    }
}

