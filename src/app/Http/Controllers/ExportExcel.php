<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Excel;
use LaravelEnso\Menus\app\Tables\Builders\MenuTable;

class ExportExcel extends Controller
{
    use Excel;

    protected $tableClass = MenuTable::class;
}
