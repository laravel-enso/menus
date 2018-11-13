<?php

use Tests\TestCase;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\MenuManager\app\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\FormBuilder\app\TestTraits\EditForm;
use LaravelEnso\FormBuilder\app\TestTraits\CreateForm;
use LaravelEnso\FormBuilder\app\TestTraits\DestroyForm;
use LaravelEnso\VueDatatable\app\Traits\Tests\Datatable;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class MenuTest extends TestCase
{
    use CreateForm, Datatable, DestroyForm, EditForm, RefreshDatabase;

    private $permissionGroup = 'system.menus';

    private $testModel;

    protected function setUp()
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed()
            ->actingAs(User::first());

        $this->testModel = factory(Menu::class)
            ->make();
    }

    /** @test */
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
                'id' => $menu->id,
            ])->assertJsonStructure([
                'message'
            ]);
    }

    /** @test */
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

    /** @test */
    public function cant_destroy_if_is_parent()
    {
        $parentMenu = factory(Menu::class)->create([
            'permission_id' => null,
            'has_children' => true,
        ]);

        $this->testModel->parent_id = $parentMenu->id;
        $this->testModel->save();

        $this->expectException(ConflictHttpException::class);

        $this->delete(route('system.menus.destroy', $parentMenu->id, false))
            ->assertStatus(409)
            ->assertJsonStructure(['message']);

        $this->assertNotNull($parentMenu->fresh());
    }
}
