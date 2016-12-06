<?php

use Illuminate\Database\Seeder;

class info_event extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('infos_events')->delete();
        DB::table('infos_events')->insert(array('nomEvenement' => 'Evenement par defaut'));
    }
}
