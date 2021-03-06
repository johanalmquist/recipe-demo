<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
class RecipeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanAddRecipes()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $this->withoutExceptionHandling();
        $data = [
            'name' => $name = 'Minna hammbugre',
            'slug' => Str::slug($name),
            'desctiption' => 'fndfjdfnjknffnjkfdjkfjdndnf',
            'how_to' => 'jfdkfhkjdhfkjdhjkdh',
            'duration' => '50'
        ];

        $this->post('api/recipes', $data)
            ->assertSessionDoesntHaveErrors([
                'name',
                'how_to',
                'duration'
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('recipes', $data);
    }

    public function testRecipeMustHaveName(){
        Sanctum::actingAs(factory(User::class)->create());
        //$this->withoutExceptionHandling();
        $data = [
            'how_to' => 'jfdkfhkjdhfkjdhjkdh',
            'duration' => '50'
        ];
        $this->post('api/recipes', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }

    public function testRecipeMustHaveDuration(){
        Sanctum::actingAs(factory(User::class)->create());
        $data = [
            'name' => 'jfdkfhkjdhfkjdhjkdh',
            'how_to' => '50'
        ];
        $this->post('api/recipes', $data)
            ->assertStatus(302)
            ->assertSessionHasErrors(['duration']);
    }

    public function testCanShowRecpie()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $data = factory('App\Recipe')->create();
        $this->get("api/recipes/{$data->id}")
            ->assertJsonStructure([
                'id', 'name', 'slug', 'how_to', 'image', 'duration', 'desctiption', 'created_at', 'updated_at'
            ])->assertJson([
                'name' => $data->name,
                'slug' => $data->slug,
                'duration' => $data->duration
            ]);
    }

    public function testCanUpdateARecpie()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $this->withoutExceptionHandling();
        $data = factory('App\Recipe')->create();
        $new_data = [
            'desctiption' => $data->desctiption,
            'duration' => $data->duration,
            'how_to' => 'Först hugger man ner en massa träd. EN MASSA TRÄD!'
        ];
        $this->patch("api/recipes/{$data->id}", $new_data)
            ->assertJsonStructure([
                'id', 'name', 'slug', 'how_to', 'image', 'duration', 'desctiption', 'created_at', 'updated_at'
            ])
            ->assertJson([
                'how_to' => $new_data['how_to']
            ]);
    }

    public function testCanDeleteARecpie()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $data = factory('App\Recipe')->create();
        $this->delete("api/recipes/$data->id")
            ->assertStatus(204);
        $this->get("api/recipes/$data->id")
            ->assertStatus(404);
    }

    public function testCanShowAllRecpiesWithPagination()
    {
        factory('App\Recipe', 100)->create();
        $this->get('api/recipes')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [ 'id', 'name', 'slug', 'how_to', 'image', 'duration', 'desctiption', 'created_at', 'updated_at']
                ],
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => ['current_page', 'last_page', 'from', 'to', 'path', 'per_page', 'total']
            ]);
    }
}
