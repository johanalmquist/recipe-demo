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
            'name' => 'L'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'dl'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'msk'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'tsk'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'krm'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'kg'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'hg'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'g'
        ]);
        \Illuminate\Support\Facades\DB::table('measurment_units')->insert([
            'name' => 'st'
        ]);

    }
}
