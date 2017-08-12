<?php

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\TestHelper\app\Classes\TestHelper;

class MenuReorderTest extends TestHelper
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
    public function reorder()
    {
        $this->get('/system/menus/reorder')
            ->assertStatus(200)
            ->assertViewIs('laravel-enso/menumanager::reorder');
    }

    /** @test */
    public function setOrder()
    {
        $firstMenu = $this->createMenu();
        $secondMenu = $this->createMenu();
        $menus = collect([$firstMenu, $secondMenu]);

        $response = $this->patch('/system/menus/setOrder', $this->patchParams($menus));

        $response->assertStatus(200);

        $this->assertEquals(0, $secondMenu->fresh()->order);
        $this->assertEquals(1, $firstMenu->fresh()->order);
    }

    private function createMenu()
    {
        return Menu::create([
            'parent_id'    => null,
            'name'         => $this->faker->word,
            'icon'         => $this->faker->word,
            'link'         => null,
            'has_children' => 0,
        ]);
    }

    private function patchParams($menus)
    {
        $menus->each(function ($menu) {
            $menu->unique_id = $menu->id;
        });

        $data['menus'] = $menus->reverse()->values()->toArray();

        return $data;
    }
}
