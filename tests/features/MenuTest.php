<?php

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\TestHelper\app\Classes\TestHelper;
use LaravelEnso\TestHelper\app\Traits\TestCreateForm;
use LaravelEnso\TestHelper\app\Traits\TestDataTable;

class MenuTest extends TestHelper
{
    use DatabaseMigrations, TestDataTable, TestCreateForm;

    private $faker;
    private $prefix = 'system.menus';

    protected function setUp()
    {
        parent::setUp();

        // $this->disableExceptionHandling();
        $this->faker = Factory::create();
        $this->signIn(User::first());
    }

    /** @test */
    public function store()
    {
        $postParams = $this->postParams();
        $response = $this->post(route('system.menus.store', [], false), $postParams);

        $menu = Menu::whereName($postParams['name'])->first();

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message'  => 'The menu was created!',
                'redirect' => '/system/menus/'.$menu->id.'/edit',
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
        $menu = Menu::create($this->postParams());
        $menu->name = 'edited';

        $this->patch(route('system.menus.update', $menu->id, false), $menu->toArray())
            ->assertStatus(200)
            ->assertJson(['message' => __(config('enso.labels.savedChanges'))]);

        $this->assertEquals('edited', $menu->fresh()->name);
    }

    /** @test */
    public function destroy()
    {
        $menu = Menu::create($this->postParams());
        var_dump(route('administration.users.destroy', 3, false));
        var_dump(route('system.menus.destroy', 3, false));
        $this->delete(route('system.menus.destroy', $menu->id, false));
            // ->assertStatus(200)
            // ->assertJsonFragment(['message']);

        $this->assertNull($menu->fresh());
    }

    /** @test */
    public function cant_destroy_if_is_parent()
    {
        $parentMenu = $this->createParentMenu();
        $this->createChildMenu($parentMenu);

        $this->expectException(EnsoException::class);

        $this->delete(route('system.menus.destroy', $parentMenu->id, false))
            ->assertStatus(302)
            ->assertJson(['message']);

        $this->assertNotNull($parentMenu->fresh());
    }

    private function createParentMenu()
    {
        return Menu::create([
            'parent_id'    => null,
            'name'         => $this->faker->word,
            'icon'         => $this->faker->word,
            'link'         => null,
            'has_children' => 1,
        ]);
    }

    private function createChildMenu($parentMenu)
    {
        Menu::create([
            'parent_id'    => $parentMenu->id,
            'name'         => $this->faker->word,
            'icon'         => $this->faker->word,
            'link'         => null,
            'has_children' => 0,
        ]);
    }

    private function postParams()
    {
        return [
            'parent_id'    => null,
            'name'         => $this->faker->word,
            'icon'         => $this->faker->word,
            'link'         => null,
            'has_children' => 0,
            '_method'      => 'POST',
        ];
    }
}
