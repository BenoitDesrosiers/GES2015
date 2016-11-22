<?php

use App\Models\DelegueCourriel;
use App\Models\DelegueTelephone;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Delegue;
use App\Models\Region;
use App\Models\RolePourDelegue;


class DeleguesTableSeeder extends Seeder {


	public function run()
	{
		
		$regions = Region::all();
		$roles = RolePourDelegue::all();
		
		$items = [
		//nom, prenom, region_id, role_pour_delegue_id, accreditation (1=oui, 0=non), sexe(1=Femme, 0=Homme), date_naissance, adresse, telephone x 2, courriel
		["Gates","Bill",14,1,1,0,"2000-01-23","123 rue Delatortue","819-472-5555","819-472-5","billgates@microsoft.com"],
		["Jobs","Steve",13,2,1,0,"1980-06-28","456 rue Dulapin","819-473-5556","819-472-6","stevejobs@apple.com"]
		];

		DB::table('delegues')->delete();
		foreach($items as $item) {
			$delegue = new Delegue();
		    $delegue->nom = $item[0];
			$delegue->prenom = $item[1];
			$delegue->region_id = $regions[$item[2]]->id;
			$delegue->role_pour_delegue_id = $roles[$item[3]]->id;
			$delegue->accreditation = $item[4];
			$delegue->sexe = $item[5];
			$delegue->date_naissance = $item[6];
			$delegue->adresse = $item[7];
            $delegue->save();

            $telephone_del = New DelegueTelephone();
            $telephone_del->telephone = $item[8];
            $telephone_del->delegue()->associate($delegue);
            $telephone_del->save();

            $telephone_del = New DelegueTelephone();
            $telephone_del->telephone = $item[9];
            $telephone_del->delegue()->associate($delegue);
            $telephone_del->save();

            $courriel_del = New DelegueCourriel();
            $courriel_del->courriel = $item[10];
            $courriel_del->delegue()->associate($delegue);
            $courriel_del->save();


		}
	}
}