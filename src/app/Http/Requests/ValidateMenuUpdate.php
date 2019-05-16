<?php

namespace LaravelEnso\Menus\app\Http\Requests;

class ValidateMenuUpdate extends ValidateMenuCreate
{
    protected function nameUnique()
    {
        return parent::nameUnique()->ignore($this->route('menu')->id);
    }
}
