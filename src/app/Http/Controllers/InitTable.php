<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Init;
use LaravelEnso\Menus\app\Tables\Builders\MenuTable;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = MenuTable::class;
}
