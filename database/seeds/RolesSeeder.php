<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\RolesPourDelegue;

class RolesTableSeeder extends Seeder {


	public function run()
	{
		

		$items = [
		//Nom, Description
		["Assistant","C'est un assistant. Il fait des trucs d'assistant."],
		["Soigneur","Un soigneur guéri un athlète à l'aide de sa magie blanche."],
		["Accompagnateur","Un accompagnateur accompagne un athlète pour qu'il ne soit pas seul."]
		];

		DB::table('roles_pour_delegues')->delete();
		foreach($items as $item) {
			$role = new RolesPourDelegue();
		    $role->nom = $item[0];
		    $role->description = $item[1];
            $role->save();	
		}
	}
}