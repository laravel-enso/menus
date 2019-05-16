<?php

namespace LaravelEnso\Menus\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\VueDatatable\app\Traits\Excel;
use LaravelEnso\VueDatatable\app\Traits\Datatable;
use LaravelEnso\Menus\app\Tables\Builders\MenuTable;

class Table extends Controller
{
    use Datatable, Excel;

    protected $tableClass = MenuTable::class;
}
