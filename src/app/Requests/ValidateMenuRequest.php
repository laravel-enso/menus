<?php

namespace LaravelEnso\MenuManager\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateMenuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'         => 'required',
            'icon'         => 'required',
            'has_children' => 'required',
        ];
    }
}