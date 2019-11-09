<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\app\Tables\Builders\MenuTable;
use LaravelEnso\Tables\app\Traits\Excel;

class ExportExcel extends Controller
{
    use Excel;

    protected $tableClass = MenuTable::class;
}
