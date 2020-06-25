<?php

namespace LaravelEnso\Menus\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\Tables\Builders\MenuTable;
use LaravelEnso\Tables\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected $tableClass = MenuTable::class;
}
