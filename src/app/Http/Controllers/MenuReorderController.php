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

    public function index()
    {
        return $this->menus->index();
    }

    public function update()
    {
        return $this->menus->update();
    }
}
