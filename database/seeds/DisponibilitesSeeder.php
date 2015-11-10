<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Disponibilite;

class DisponibilitesTableSeeder extends Seeder {


	public function run()
	{
		$infos = [
		//benevole_id, title, isAllDay, start, end
		["2", "Sur appel seulement","false","2015-11-04T0800","2015-11-05T0800"],
		["2", "", "false", "2015-11-07T0800","2015-11-08T0800"],
        ["3", "Sauf entre midi et 13h", "true", "2015-11-07T0800","2015-11-07T0800"]];

        DB::table('disponibilites')->delete();
		foreach($infos as $info) {
		    $disponibilite = new Disponibilite();
		    $disponibilite->benevole_id = $info[0];
		    $disponibilite->title = $info[1];
		    $disponibilite->isAllDay = $info[2];
		    $disponibilite->start = $info[3];
		    $disponibilite->end = $info[4];
            $benevole->save();		
        }
     		
    }

}
