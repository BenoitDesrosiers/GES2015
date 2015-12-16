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

		DB::table('delegues_roles')->delete();
		foreach($items as $item) {
			DB::table('delegues_roles')->insert(array('delegue_id' => $item[0], 'role_id'=>$item[1]));
		}
	}
}