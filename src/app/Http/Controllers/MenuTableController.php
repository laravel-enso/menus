<?php

namespace LaravelEnso\MenuManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\DataTable\app\Traits\DataTable;
use LaravelEnso\MenuManager\app\DataTable\MenusTableStructure;
use LaravelEnso\MenuManager\app\Models\Menu;

class MenuTableController extends Controller
{
    use DataTable;

    protected $tableStructureClass = MenusTableStructure::class;

    public function getTableQuery()
    {
        return Menu::select(\DB::raw('menus.id as DT_RowId, menus.name, menus.icon,
            parent_menus.name as parent, menus.link, menus.created_at, menus.updated_at')
        )->leftJoin('menus as parent_menus', 'menus.parent_id', '=', 'parent_menus.id');
    }
}
