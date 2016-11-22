<?php

use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersRolesSeederTable extends Seeder
{
    public function run(){


        $items = [
            //user_id, roles_id
            [0,[0,1,2]],[1,[1,2]],[2,[2]]
        ];

        $users = User::all();

        $roles = Role::all();



        DB::table('role_user')->delete();

        foreach($items as $item) {
            $rolesAssigne = $item[1];
            foreach($rolesAssigne as $roleAssigne){
                $users[$item[0]]->roles()->attach($roles[$roleAssigne]);
            }
        }
    }
}