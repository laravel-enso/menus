<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\app\Tables\Builders\MenuTable;
use LaravelEnso\Tables\app\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = MenuTable::class;
}
