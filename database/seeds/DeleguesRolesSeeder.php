<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\RolePourDelegue;
use App\Models\Delegue;


class DeleguesRolesTableSeeder extends Seeder {


    public function run()
    {


        $items = [
            //Delegue_id, role_pour_delegue_id
            [0,0],[1,1],[1,2]
        ];

        $delegues = Delegue::all();

        $roles = RolePourDelegue::all();


        DB::table('delegues_roles_pour_delegues')->delete();


        foreach($items as $item) {
            print_r($items);
            $delegues[$item[0]]->rolesPourDelegues()->attach($roles[$item[1]]->id);
        }
    }
}