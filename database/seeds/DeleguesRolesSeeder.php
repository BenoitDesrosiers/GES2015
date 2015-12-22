<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Delegue;


class DeleguesRolesTableSeeder extends Seeder {


	public function run()
	{
		

		$items = [
		//Delegue_id, role_id
		[0,0],[1,1],[1,2]
		];

		$delegues = Delegue::all();
		$roles = Role::all();
		
	
		DB::table('delegues_roles')->delete();  

				
		foreach($items as $item) {
			$delegues[$item[0]]->roles()->attach($roles[$item[1]]->id);
		}
	}
}