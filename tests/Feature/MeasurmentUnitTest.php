<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeasurmentUnitTest extends TestCase
{
    use RefreshDatabase;

    public function testCanAddMeasurmentUnit()
    {
        $this->withoutExceptionHandling();
        $data = factory('App\MeasurmentUnit')->raw();
        $this->post('api/measurment-units', $data)
            ->assertSessionDoesntHaveErrors();
        $this->assertDatabaseHas('measurment_units', $data);
    }

    public function testCanShowAMeasurmentUnit()
    {
        $data = factory('App\MeasurmentUnit')->create();
        $this->get("api/measurment-units/$data->id")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name', 'short_name'
                ]
            ])->assertJson([
                'data' => [
                    'name' => $data->name,
                    'short_name' => $data->short_name
                ]
            ]);
    }

    public function testCanUpdateAnMeasurmentUnit()
    {
        $this->withoutExceptionHandling();
        $data = factory('App\MeasurmentUnit')->create();
        $new_data = ['name' => 'hej'];
        $this->patch("api/measurment-units/$data->id", $new_data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'name',
                'short_name'
            ])
            ->assertJson([
                'name' => $new_data['name'],
                'short_name' => $data->short_name
            ]);
    }

    public function testCanDeleteAMeasurmentUnit()
    {
        //$this->withoutExceptionHandling();
        $data = factory('App\MeasurmentUnit')->create();
        $this->delete("api/measurment-units/$data->id")
            ->assertStatus(200);
        $this->get("api/measurment-units/$data->id")
            ->assertStatus(404);
    }

    public function testCanShowAllMeasurmentUnits()
    {
        factory('App\MeasurmentUnit', '10')->create();
        $this->get('api/measurment-units')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['name', 'short_name', 'created_at', 'updated_at'],
                ],
            ]);
    }
}
