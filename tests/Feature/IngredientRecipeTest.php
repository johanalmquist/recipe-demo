<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IngredientRecipeTest extends TestCase
{
    use RefreshDatabase;

    public function testCanAddIngredient()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $this->withoutExceptionHandling();
        $recipe = factory('App\Recipe')->create();
        $meas = factory('App\MeasurmentUnit')->create();
        $data = [
            'name' => 'tomat',
            'measurment_unit' => $meas->id,
            'amount' => '5'
        ];
        $this->post("api/ingredients/recipe/$recipe->id", $data)
            ->assertStatus(201)
            ->assertSessionDoesntHaveErrors([
                'name',
                'measurment_unit_id',
                'amount'
            ]);
        $this->assertDatabaseHas('ingredients', [
            'name' => $data['name'],
            'recipe_id' => $recipe->id,
            'measurment_unit_id' => $data['measurment_unit'],
            'amount' => $data['amount']
        ]);

    }

    public function testCanShowAllIngredientForARecipe()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $this->withoutExceptionHandling();
        $recipe = factory('App\Recipe')->create();
        $meas = factory('App\MeasurmentUnit')->create();
        $data = [
            'name' => 'tomat',
            'measurment_unit' => $meas->id,
            'amount' => '5'
        ];
        $this->post("api/ingredients/recipe/$recipe->id", $data);

        $this->get("api/ingredients/recipe/$recipe->id")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['name', 'amount', 'measurment_unit_id', 'recipe_id', 'id'],
                ],
            ]);
    }

    public function testCanShowAOneIngredientForARecipe()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $recipe = factory('App\Recipe')->create();
        $meas = factory('App\MeasurmentUnit')->create();
        $data = [
            'name' => 'tomat',
            'measurment_unit' => $meas->id,
            'amount' => '5'
        ];
        $this->post("api/ingredients/recipe/$recipe->id", $data);

        $this->get("api/ingredients/recipe/$recipe->id/ingredient/1")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'amount', 'unit']
            ])
            ->assertJson([
                'data' => [
                    'name' => 'tomat',
                    'amount' => 5,
                    'unit' => $meas->name
                ]
            ]);
    }

    public function testCanUpdateAIngredientForAReacipe()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $this->withoutExceptionHandling();
        $recipe = factory('App\Recipe')->create();
        $meas = factory('App\MeasurmentUnit')->create();
        $data = [
            'name' => 'tomat',
            'measurment_unit' => $meas->id,
            'amount' => '5'
        ];
        $this->post("api/ingredients/recipe/$recipe->id", $data);

        $new_data = [
            'measurment_unit' => $meas->id,
            'amount' => '2'
        ];
        $this->patch("api/ingredients/recipe/$recipe->id/ingredient/1", $new_data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'amount', 'unit']
            ])
            ->assertJson([
                'data' => [
                    'amount' => 2
                ]
            ]);
    }

    public function testCanDeleteAIngredient()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $recipe = factory('App\Recipe')->create();
        $meas = factory('App\MeasurmentUnit')->create();
        $data = [
            'name' => 'tomat',
            'measurment_unit' => $meas->id,
            'amount' => '5'
        ];
        $this->post("api/ingredients/recipe/$recipe->id", $data);

        $this->delete("api/ingredients/recipe/$recipe->id/ingredient/1")
            ->assertStatus(200);
        $this->get("api/ingredients/recipe/$recipe->id/ingredient/1")
            ->assertStatus(404);
    }
}
