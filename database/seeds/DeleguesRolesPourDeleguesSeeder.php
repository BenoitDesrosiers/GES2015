<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\RolesPourDelegue;
use App\Models\Delegue;


class DeleguesRolesPourDeleguesTableSeeder extends Seeder {


    public function run()
    {


        $items = [
            //Delegue_id, role_pour_delegue_id
            [0,0],[1,1],[1,2]
        ];

        $delegues = Delegue::all();

        $roles = RolesPourDelegue::all();


        DB::table('delegues_roles_pour_delegues')->delete();


        foreach($items as $item) {
            $delegues[$item[0]]->rolesPourDelegues()->attach($roles[$item[1]]->id);
        }
    }
}