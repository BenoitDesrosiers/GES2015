<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesTableSeeder extends Seeder {


	public function run()
	{
		DB::table('roles')->delete();

		$items = [
		//Nom, Description
		["Assistant","C'est un assistant. Il fait des trucs d'assistant."],
		["Soigneur","Un soigneur guéri un athlète à l'aide de sa magie blanche."],
		["Accompagnateur","Un accompagnateur accompagne un athlète pour qu'il ne soit pas seul."]
		];

		foreach($items as $item) {
			DB::table('roles')->insert(array('nom' => $item[0], 'description'=>$item[1]));
		}
	}
}