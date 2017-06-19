<?php

namespace LaravelEnso\MenuManager\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateMenuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $menu = $this->route('menu');
        $nameUnique = Rule::unique('menus', 'name');
        $nameUnique = $this->_method == 'PATCH' ? $nameUnique->ignore($menu->id) : $nameUnique;

        return [
            'name'         => ['required', $nameUnique],
            'icon'         => 'required',
            'has_children' => 'required',
        ];
    }
}
