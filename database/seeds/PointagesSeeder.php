<?php

use Illuminate\Database\Seeder;
use App\Models\Pointage;
use App\Models\Sport;

class PointagesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('benevoles')->delete();
        $sports = Sport::all();
        
        foreach ($sports as $sport) {
        	$pointage = new Pointage();
        	$pointage->sport_id = $sport->id;
        	$pointage->position = 1;
        	$pointage->valeur = 0;
        	$pointage->save();
        }
    }
}
