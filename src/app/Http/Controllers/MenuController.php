<?php

namespace LaravelEnso\MenuManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelEnso\DataTable\app\Traits\DataTable;
use LaravelEnso\MenuManager\app\DataTable\MenusTableStructure;
use LaravelEnso\MenuManager\app\Http\Requests\ValidateMenuRequest;
use LaravelEnso\MenuManager\app\Http\Services\MenuService;
use LaravelEnso\MenuManager\app\Models\Menu;

class MenuController extends Controller
{
    use DataTable;

    private $menus;

    protected $tableStructureClass = MenusTableStructure::class;

    public function __construct(Request $request)
    {
        $this->menus = new MenuService($request);
    }

    public function getTableQuery()
    {
        return $this->menus->getTableQuery();
    }

    public function index()
    {
        return $this->menus->index();
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
