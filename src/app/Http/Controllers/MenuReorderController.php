<?php

namespace LaravelEnso\MenuManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelEnso\MenuManager\app\Http\Services\MenuReorderService;

class MenuReorderController extends Controller
{
    private $menus;

    public function __construct(Request $request)
    {
        $this->menus = new MenuReorderService($request);
    }

    public function reorder()
    {
        return $this->menus->reorder();
    }

    public function setOrder()
    {
        return $this->menus->setOrder();
    }
}
