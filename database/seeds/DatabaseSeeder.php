<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MeasurmentUnitSeeder::class);
        $this->call(RecipeSeeder::class);
        $this->call(UserSeeder::class);
    }
}
