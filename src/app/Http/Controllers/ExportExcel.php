<?php

namespace LaravelEnso\Menus\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Menus\App\Tables\Builders\MenuTable;
use LaravelEnso\Tables\App\Traits\Excel;

class ExportExcel extends Controller
{
    use Excel;

    protected $tableClass = MenuTable::class;
}
