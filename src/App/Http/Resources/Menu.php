<?php

namespace LaravelEnso\Menus\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Menu extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => $this->icon,
            'hasChildren' => $this->has_children,
            'children' => $this->children ? self::collection($this->children) : null,
            'route' => $this->route,
            'expanded' => false,
            'active' => false,
        ];
    }
}
