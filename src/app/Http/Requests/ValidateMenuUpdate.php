<?php

namespace LaravelEnso\Menus\app\Http\Requests;

use Illuminate\Validation\Rule;
use LaravelEnso\Menus\app\Http\Requests\ValidateMenuCreate;

class ValidateMenuUpdate extends ValidateMenuCreate
{
    protected function nameUnique()
    {
        return parent::nameUnique()->ignore($this->route('menu')->id);
    }
}
