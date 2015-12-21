<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Disponibilite;
use App\Models\Benevole;

class DisponibilitesTableSeeder extends Seeder {


	public function run()
	{
		$mois_courant = date("Y-m");
		$infos = [
		//benevole_id, title, isAllDay, start, end
		["0", "Sur appel seulement","0","04 10:00:00","04 14:00:00"],
		["1", "un rappel", "1", "06 08:00:00","06 17:30:00"],
        ["2", "Sauf entre midi et 13h", "1", "07 08:00:00","07 17:30:00"]];

		$benevoles = Benevole::all();
        DB::table('disponibilites')->delete();
		foreach($infos as $info) {
		    $disponibilite = new Disponibilite();
		    $disponibilite->benevole_id = $benevoles[$info[0]]->id; 
		    $disponibilite->title = $info[1];
		    $disponibilite->isAllDay = $info[2];
		    $disponibilite->start = $mois_courant."-".$info[3];
		    $disponibilite->end = $mois_courant."-".$info[4];
            $disponibilite->save();		
        }
     		
    }

}
