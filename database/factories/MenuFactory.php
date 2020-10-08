<?php

namespace LaravelEnso\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Permissions\Models\Permission;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition()
    {
        return [
            'permission_id' => Permission::factory(),
            'parent_id' => null,
            'name' => $this->faker->word,
            'icon' => $this->faker->word,
            'has_children' => false,
            'order_index' => $this->faker->randomNumber(3),
        ];
    }
}
