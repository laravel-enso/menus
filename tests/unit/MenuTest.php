<?php

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\MenuManager\app\Models\Menu;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use DatabaseMigrations;

    private $faker;

    protected function setUp()
    {
        parent::setUp();

        // $this->disableExceptionHandling();
        $this->faker = Factory::create();
        $this->actingAs(User::first());
    }

    /** @test */
    public function index()
    {
        $response = $this->get('/system/menus');

        $response->assertStatus(200);
    }

    /** @test */
    public function create()
    {
        $response = $this->get('/system/menus/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function store()
    {
        $postParams = $this->postParams();
        $response = $this->post('/system/menus', $postParams);

        $menu = Menu::whereName($postParams['name'])->first();

        $response->assertRedirect('/system/menus/'.$menu->id.'/edit');
        $response->assertSessionHas('flash_notification');
    }

    /** @test */
    public function edit()
    {
        $menu = Menu::create($this->postParams());

        $response = $this->get('/system/menus/'.$menu->id.'/edit');

        $response->assertStatus(200);
    }

    /** @test */
    public function update()
    {
        $menu = Menu::create($this->postParams());
        $menu->name = 'edited';
        $menu->method = 'PATCH';

        $response = $this->patch('/system/menus/'.$menu->id, $menu->toArray());

        $response->assertStatus(302);
        $response->assertSessionHas('flash_notification');
        $this->assertTrue($menu->fresh()->name === 'edited');
    }

    /** @test */
    public function destroy()
    {
        $menu = Menu::create($this->postParams());

        $response = $this->delete('/system/menus/'.$menu->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['message']);
        $this->assertNull($menu->fresh());
    }

    /** @test */
    public function cant_destroy_if_is_parent()
    {
        $parentMenu = $this->createParentMenu();
        $this->createChildMenu($parentMenu);

        $response = $this->delete('/system/menus/'.$parentMenu->id);

        $response->assertStatus(302);
        $this->assertTrue(session('flash_notification')[0]->level === 'danger');
        $this->assertNotNull($parentMenu->fresh());
    }

    private function createParentMenu()
    {
        $parentMenu = Menu::create([
            'parent_id'                  => null,
            'name'                       => $this->faker->word,
            'icon'                       => $this->faker->word,
            'link'                       => null,
            'has_children'               => 1,
            ]);
        return $parentMenu;
    }

    private function createChildMenu($parentMenu)
    {
        $menu = Menu::create([
            'parent_id'                  => $parentMenu->id,
            'name'                       => $this->faker->word,
            'icon'                       => $this->faker->word,
            'link'                       => null,
            'has_children'               => 0,
            ]);
    }

    private function postParams()
    {
        return [
            'parent_id'                  => null,
            'name'                       => $this->faker->word,
            'icon'                       => $this->faker->word,
            'link'                       => null,
            'has_children'               => 0,
            '_method'                    => 'POST',
        ];
    }
}
