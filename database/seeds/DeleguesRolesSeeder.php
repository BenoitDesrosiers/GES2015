<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

//use App\Models\Role;

class DeleguesRolesTableSeeder extends Seeder {


	public function run()
	{
		

		$items = [
		//Delegue_id, role_id
		[1,1],[1,2],[2,3]
		];

		DB::table('delegues_roles')->delete();  //FIXME: à refaire en allant chercher les délégués et les roles dans la bd et en faisant un save au lieu d'insérer directement dnas delegues_roles.
		foreach($items as $item) {
			DB::table('delegues_roles')->insert(array('delegue_id' => $item[0], 'role_id'=>$item[1]));
		}
	}
}