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
            'name' => 'required',
            'icon' => 'required',
            'has_children' => 'boolean',
            'order_index' => 'numeric|required',
            'link' => 'nullable',
            'parent_id' => 'nullable',
            'roleList' => 'array'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->get('has_children') && $this->filled('link')) {
                $validator->errors()->add('has_children', 'The menu must not to be a parent if the link is not null');
                $validator->errors()->add('link', 'The link has to be null if the menu is a parent');
            }

            if (!$this->get('has_children') && !$this->filled('link')) {
                $validator->errors()->add('has_children', 'The menu must be a parent if the link is null');
                $validator->errors()->add('link', 'The link cannot be null if the menu is not a parent');
            }
        });
    }
}
