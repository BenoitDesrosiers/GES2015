<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Disponibilite;

class DisponibilitesTableSeeder extends Seeder {


	public function run()
	{
		$infos = [
		//benevole_id, title, isAllDay, start, end
		["2", "Sur appel seulement","0","2015-11-04 10:00:00","2015-11-04 14:00:00"],
		["2", "", "1", "2015-11-06 08:00:00","2015-11-06 17:30:00"],
        ["3", "Sauf entre midi et 13h", "1", "2015-11-07 08:00:00","2015-11-07 17:30:00"]];

        DB::table('disponibilites')->delete();
		foreach($infos as $info) {
		    $disponibilite = new Disponibilite();
		    $disponibilite->benevole_id = $info[0];
		    $disponibilite->title = $info[1];
		    $disponibilite->isAllDay = $info[2];
		    $disponibilite->start = $info[3];
		    $disponibilite->end = $info[4];
            $disponibilite->save();		
        }
     		
    }

}
