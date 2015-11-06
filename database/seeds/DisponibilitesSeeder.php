<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Disponibilite;

class DisponibilitesTableSeeder extends Seeder {


	public function run()
	{
		DB::table('disponibilites')->delete();

		$disponibilites = [
		//benevole_id, title, isAllDay, start, end
		["2","Sur appel seulement","false","2015-11-04T0800","2015-11-05T0800"],
		];

		foreach($disponibilites as $disponibilite) {
			DB::table('disponibilites')->insert(array('benevole_id'=>$disponibilite[0],'title'=>$disponibilite[1],'isAllDay'=>$disponibilite[2],'start'=>$disponibilite[3],'end'=>$disponibilite[4]));
     		
        }
	}
}
