<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\Forms\TestTraits\CreateForm;
use LaravelEnso\Forms\TestTraits\DestroyForm;
use LaravelEnso\Forms\TestTraits\EditForm;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Roles\Models\Role;
use LaravelEnso\Tables\Traits\Tests\Datatable;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use CreateForm;
    use Datatable;
    use DestroyForm;
    use EditForm;
    use RefreshDatabase;

    private $permissionGroup = 'system.menus';

    private $testModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->actingAs(User::first());

        $this->testModel = Menu::factory()
            ->make();
    }

    #[Test]
    public function can_store_menu()
    {
        $response = $this->post(
            route('system.menus.store'),
            $this->testModel->toArray()
        );

        $menu = Menu::whereName($this->testModel->name)
            ->first();

        $response->assertStatus(200)
            ->assertJsonFragment([
                'redirect' => 'system.menus.edit',
                'param'    => ['menu' => $menu->id],
            ])->assertJsonStructure(['message']);
    }

    #[Test]
    public function can_update_menu()
    {
        $this->testModel->save();

        $this->testModel->name = 'edited';

        $this->patch(
            route('system.menus.update', $this->testModel->id, false),
            $this->testModel->toArray()
        )->assertStatus(200)->assertJsonStructure(['message']);

        $this->assertEquals('edited', $this->testModel->fresh()->name);
    }

    #[Test]
    public function cant_destroy_if_is_parent()
    {
        $parentMenu = Menu::factory()->create([
            'permission_id' => null,
            'has_children'  => true,
        ]);

        $this->testModel->parent_id = $parentMenu->id;
        $this->testModel->save();
        $this->delete(route('system.menus.destroy', $parentMenu->id, false))
            ->assertStatus(409);

        $this->assertNotNull($parentMenu->fresh());
    }

    #[Test]
    public function cant_destroy_if_used_as_default_menu()
    {
        $this->testModel->save();

        Role::factory()->create(['menu_id' => $this->testModel->id]);

        $this->delete(route('system.menus.destroy', $this->testModel->id, false))
            ->assertStatus(409);

        $this->assertNotNull($this->testModel->fresh());
    }

    #[Test]
    public function rejects_leaf_menu_without_permission()
    {
        $this->post(route('system.menus.store', [], false), [
            ...$this->testModel->toArray(),
            'permission_id' => null,
            'has_children' => false,
        ])->assertStatus(302)
            ->assertSessionHasErrors(['has_children', 'permission_id']);
    }

    #[Test]
    public function rejects_parent_menu_with_permission()
    {
        $this->post(route('system.menus.store', [], false), [
            ...$this->testModel->toArray(),
            'has_children' => true,
        ])->assertStatus(302)
            ->assertSessionHasErrors(['has_children', 'permission_id']);
    }

    #[Test]
    public function can_organize_nested_menus()
    {
        $parent = Menu::factory()->create([
            'permission_id' => null,
            'has_children' => true,
            'order_index' => 10,
        ]);
        $child = Menu::factory()->create([
            'parent_id' => $parent->id,
            'order_index' => 30,
        ]);
        $sibling = Menu::factory()->create(['order_index' => 20]);

        $this->put(route('system.menus.organize', [], false), [
            'menus' => [
                [
                    'id' => $sibling->id,
                    'has_children' => false,
                    'children' => [],
                ],
                [
                    'id' => $parent->id,
                    'has_children' => true,
                    'children' => [
                        [
                            'id' => $child->id,
                            'has_children' => false,
                            'children' => [],
                        ],
                    ],
                ],
            ],
        ])->assertStatus(200)
            ->assertJsonFragment([
                'message' => __('The menu order has been sucessfully updated'),
            ]);

        $this->assertSame(10, $sibling->fresh()->order_index);
        $this->assertSame(20, $parent->fresh()->order_index);
        $this->assertSame(10, $child->fresh()->order_index);
    }
}
