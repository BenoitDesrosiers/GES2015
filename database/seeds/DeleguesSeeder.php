<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Delegue;
use App\Models\Region;
use App\Models\Role;


class DeleguesTableSeeder extends Seeder {


	public function run()
	{
		
		$regions = Region::all();
		$roles = Role::all();
		
		$items = [
		//nom, prenom, region_id, role_id, accreditation (1=oui, 0=non), sexe(1=Femme, 0=Homme), date_naissance, adresse, telephone
		["Gates","Bill",14,1,1,0,"2000-01-23","123 rue Delatortue","819-472-5555","billgates@microsoft.com"],
		["Jobs","Steve",13,2,1,0,"1980-06-28","456 rue Dulapin","819-473-5555","stevejobs@apple.com"]
		];

		DB::table('delegues')->delete();
		foreach($items as $item) {
			$delegue = new Delegue();
		    $delegue->nom = $item[0];
			$delegue->prenom = $item[1];
			$delegue->region_id = $regions[$item[2]]->id;
			$delegue->role_id = $roles[$item[3]]->id;
			$delegue->accreditation = $item[4];
			$delegue->sexe = $item[5];
			$delegue->date_naissance = $item[6];
			$delegue->adresse = $item[7];
			$delegue->telephone = $item[8];
			$delegue->courriel = $item[9];
            $delegue->save();
		}
	}
}