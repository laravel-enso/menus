<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\app\Tables\Builders\MenuTable;
use LaravelEnso\Tables\app\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected $tableClass = MenuTable::class;
}
