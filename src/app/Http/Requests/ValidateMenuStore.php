<?php

namespace LaravelEnso\Menus\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateMenuStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'parent_id' => 'nullable',
            'name' => [$this->nameUnique(), 'required'],
            'permission_id' => 'nullable|exists:permissions,id',
            'icon' => 'required',
            'has_children' => 'boolean',
            'order_index' => 'numeric|required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->get('has_children') && $this->filled('permission_id')) {
                $validator->errors()->add('has_children', __('The menu must not to be a parent if the route is not null'));
                $validator->errors()->add('permission_id', __('The route has to be null if the menu is a parent'));
            }

            if (! $this->get('has_children') && ! $this->filled('permission_id')) {
                $validator->errors()->add('has_children', __('The menu must be a parent if the route is null'));
                $validator->errors()->add('permission_id', __('The route cannot be null if the menu is not a parent'));
            }
        });
    }

    protected function nameUnique()
    {
        return Rule::unique('menus', 'name')
            ->where(function ($query) {
                return $query->whereParentId($this->parent_id);
            });
    }
}
