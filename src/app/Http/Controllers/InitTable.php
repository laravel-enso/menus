<?php

namespace LaravelEnso\Menus\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\App\Tables\Builders\MenuTable;
use LaravelEnso\Tables\App\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = MenuTable::class;
}
