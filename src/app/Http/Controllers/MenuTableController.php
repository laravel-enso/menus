<?php

namespace LaravelEnso\MenuManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\VueDatatable\app\Traits\Excel;
use LaravelEnso\VueDatatable\app\Traits\Datatable;

class MenuTableController extends Controller
{
    use Datatable, Excel;

    private const Template = __DIR__ . '/../../Tables/menus.json';

    public function query()
    {
        return Menu::select(\DB::raw(
            'menus.id as dtRowId, menus.name, menus.icon, menus.has_children,
            parent_menus.name as parent, menus.link, menus.created_at, menus.updated_at'
        ))->leftJoin('menus as parent_menus', 'menus.parent_id', '=', 'parent_menus.id');
    }
}
