<?php

use Illuminate\Database\Seeder;

class MeasurmentUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'DL'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'L'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'CL'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'ML'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'MSK'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'TSK'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'KRM'
        ]);

    }
}
