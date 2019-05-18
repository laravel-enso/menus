<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Data;
use LaravelEnso\Menus\app\Tables\Builders\MenuTable;

class TableData extends Controller
{
    use Data;

    protected $tableClass = MenuTable::class;
}
