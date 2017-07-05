<?php

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\MenuManager\app\Models\Menu;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    protected function setUp()
    {
        parent::setUp();

        // $this->disableExceptionHandling();
        $this->user = User::first();
        $this->faker = Factory::create();
        $this->actingAs($this->user);
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
        $this->hasSessionConfirmation($response);
    }

    /** @test */
    public function edit()
    {
        $menu = Menu::first();

        $response = $this->get('/system/menus/'.$menu->id.'/edit');

        $response->assertStatus(200);
        // $response->assertViewHas('menu', $menu);
    }

    /** @test */
    public function update()
    {
        $menu = Menu::first();
        $menu->name = 'edited';
        $data = $menu->toArray();
        $data['_method'] = 'PATCH';

        $response = $this->patch('/system/menus/'.$menu->id, $data);

        $response->assertStatus(302);
        $this->hasSessionConfirmation($response);
        $this->assertTrue($this->wasUpdated());
    }

    /** @test */
    public function destroy()
    {
        $postParams = $this->postParams();
        Menu::create($postParams);
        $menu = Menu::whereName($postParams['name'])->first();

        $response = $this->delete('/system/menus/'.$menu->id);

        $this->hasJsonConfirmation($response);
        $this->wasDeleted($menu);
        $response->assertStatus(200);
    }

    /** @test */
    public function cantDestroyIfIsParent()
    {
        $menu = Menu::isParent()->first();

        $response = $this->delete('/system/menus/'.$menu->id);

        $response->assertStatus(302);
        $this->assertTrue($this->hasSessionErrorMessage());
        $this->wasNotDeleted($menu);
    }

    private function wasUpdated()
    {
        $menu = Menu::first(['name']);

        return $menu->name === 'edited';
    }

    private function wasDeleted($menu)
    {
        return $this->assertNull(Menu::whereName($menu->name)->first());
    }

    private function wasNotDeleted($menu)
    {
        return $this->assertNotNull(Menu::whereName($menu->name)->first());
    }

    private function hasSessionConfirmation($response)
    {
        return $response->assertSessionHas('flash_notification');
    }

    private function hasJsonConfirmation($response)
    {
        return $response->assertJsonFragment(['message']);
    }

    private function hasSessionErrorMessage()
    {
        return session('flash_notification')[0]->level === 'danger';
    }

    private function postParams()
    {
        return [
            'parent_id'                  => Menu::first(['id'])->id,
            'name'                       => 'testMenu',
            'icon'                       => 'fa-fa-icon',
            'link'                       => '/system/testMenu',
            'has_children'               => 0,
            '_method'                    => 'POST',
        ];
    }
}
