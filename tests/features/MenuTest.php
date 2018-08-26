<?php

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\TestHelper\app\Traits\SignIn;
use LaravelEnso\TestHelper\app\Traits\TestCreateForm;
use LaravelEnso\TestHelper\app\Traits\TestDataTable;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase, SignIn, TestDataTable, TestCreateForm;

    private $faker;
    private $prefix = 'system.menus';

    protected function setUp()
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed()
            ->signIn(User::first());

        $this->faker = Factory::create();
    }

    /** @test */
    public function store()
    {
        $postParams = $this->postParams();

        $response = $this->post(route('system.menus.store', [], false), $postParams);

        $menu = Menu::whereName($postParams['name'])->first();

        $response->assertStatus(200)
            ->assertJsonFragment([
                'redirect' => 'system.menus.edit',
                'id' => $menu->id,
            ])->assertJsonStructure([
                'message'
            ]);
    }

    /** @test */
    public function edit()
    {
        $menu = Menu::create($this->postParams());

        $this->get(route('system.menus.edit', $menu->id, false))
            ->assertStatus(200)
            ->assertJsonStructure(['form']);
    }

    /** @test */
    public function update()
    {
        $menu = Menu::create($this->postParams())
                    ->append(['roleList']);

        $menu->name = 'edited';

        $this->patch(route('system.menus.update', $menu->id, false), $menu->toArray())
            ->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertEquals('edited', $menu->fresh()->name);
    }

    /** @test */
    public function destroy()
    {
        $menu = Menu::create($this->postParams());

        $this->delete(route('system.menus.destroy', $menu->id, false))
            ->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertNull($menu->fresh());
    }

    /** @test */
    public function cant_destroy_if_is_parent()
    {
        $parentMenu = $this->createParentMenu();

        $this->createChildMenu($parentMenu);

        $this->expectException(ConflictHttpException::class);

        $this->delete(route('system.menus.destroy', $parentMenu->id, false))
            ->assertStatus(409)
            ->assertJsonStructure(['message']);

        $this->assertNotNull($parentMenu->fresh());
    }

    private function createParentMenu()
    {
        return Menu::create([
            'parent_id' => null,
            'name' => $this->faker->word,
            'icon' => $this->faker->word,
            'link' => null,
            'has_children' => true,
            'order_index' => 999,
        ]);
    }

    private function createChildMenu($parentMenu)
    {
        Menu::create([
            'parent_id' => $parentMenu->id,
            'name' => $this->faker->word,
            'icon' => $this->faker->word,
            'link' => null,
            'has_children' => false,
            'order_index' => 999,
        ]);
    }

    private function postParams()
    {
        return [
            'parent_id' => null,
            'name' => $this->faker->word,
            'icon' => $this->faker->word,
            'link' => $this->faker->word,
            'order_index' => 999,
            'has_children' => 0,
            '_method' => 'POST',
            'roleList' => []
        ];
    }
}
