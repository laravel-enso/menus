<?php

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelEnso\MenuManager\app\Classes\TreeMenuBuilder;
use LaravelEnso\MenuManager\app\Models\Menu;
use Tests\TestCase;

class MenuReorderTest extends TestCase
{
    use DatabaseMigrations;

    private $faker;

    protected function setUp()
    {
        parent::setUp();

        $this->disableExceptionHandling();
        $this->faker = Factory::create();
        $this->actingAs(User::first());
    }

    /** @test */
    public function reorder()
    {
        $response = $this->get('/system/menus/reorder');

        $response->assertStatus(200);
    }

    /** @test */
    public function set_order()
    {
        $firstMenu  = $this->createFirstMenu();
        $secondMenu = $this->createSecondMenu();
        $menus = Menu::orderBy('id', 'desc')->take(2)->get();

        $this->assertEquals(0, $firstMenu->order);
        $this->assertEquals(1, $secondMenu->order);

        $response = $this->patch('/system/menus/setOrder', $this->patchParams($menus));

        $response->assertStatus(200);
        $this->assertEquals(0, $secondMenu->fresh()->order);
        $this->assertEquals(1, $firstMenu->fresh()->order);
    }

    private function createFirstMenu()
    {
        $firstMenu = Menu::create([
            'parent_id'    => null,
            'name'         => $this->faker->word,
            'icon'         => $this->faker->word,
            'link'         => null,
            'has_children' => 0,
        ]);
        $firstMenu->order = 0;
        $firstMenu->save();
        return $firstMenu;
    }

    private function createSecondMenu()
    {
        $secondMenu = Menu::create([
            'parent_id'    => null,
            'name'         => $this->faker->word,
            'icon'         => $this->faker->word,
            'link'         => null,
            'has_children' => 0,
        ]);
        $secondMenu->order = 1;
        $secondMenu->save();
        return $secondMenu;
    }

    private function patchParams($menus)
    {
        $data = [];
        foreach ($menus->toArray() as $index => $menu) {
            $menu['unique_id'] = $menu['id'];
            $data['menus'][] = $menu;
        }
        return $data;
    }
}
