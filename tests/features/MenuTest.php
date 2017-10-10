<?php

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\TestHelper\app\Classes\TestHelper;

class MenuTest extends TestHelper
{
    use DatabaseMigrations;

    private $faker;

    protected function setUp()
    {
        parent::setUp();

        // $this->disableExceptionHandling();
        $this->faker = Factory::create();
        $this->signIn(User::first());
    }

    /** @test */
    public function index()
    {
        $this->get('/system/menus')
            ->assertStatus(200)
            ->assertViewIs('laravel-enso/menumanager::index');
    }

    /** @test */
    public function create()
    {
        $this->get('/system/menus/create')
            ->assertStatus(200)
            ->assertViewIs('laravel-enso/menumanager::create')
            ->assertViewHas('form');
    }

    /** @test */
    public function store()
    {
        $postParams = $this->postParams();
        $response = $this->post('/system/menus', $postParams);

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

        $this->get('/system/menus/'.$menu->id.'/edit')
            ->assertStatus(200)
            ->assertViewIs('laravel-enso/menumanager::edit')
            ->assertViewHas('form');
    }

    /** @test */
    public function update()
    {
        $menu = Menu::create($this->postParams());
        $menu->name = 'edited';

        $this->patch('/system/menus/'.$menu->id, $menu->toArray())
            ->assertStatus(200)
            ->assertJson(['message' => __(config('labels.savedChanges'))]);

        $this->assertEquals('edited', $menu->fresh()->name);
    }

    /** @test */
    public function destroy()
    {
        $menu = Menu::create($this->postParams());

        $this->delete('/system/menus/'.$menu->id)
            ->assertStatus(200)
            ->assertJsonFragment(['message']);

        $this->assertNull($menu->fresh());
    }

    /** @test */
    public function cant_destroy_if_is_parent()
    {
        $parentMenu = $this->createParentMenu();
        $this->createChildMenu($parentMenu);

        $this->delete('/system/menus/'.$parentMenu->id)
            ->assertStatus(455);

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
