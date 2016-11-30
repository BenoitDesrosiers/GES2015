<?php
use Illuminate\Database\Seeder;

use App\Models\Role;

class RolesSeeder extends Seeder {


    public function run()
    {


        $items = [
            //Name, Display_name, Description
            ["admin","Administration","Ce rôle a accès à la section administrative, normal et invite."],
            ["responsable","Responsable","Ce rôle a accès à la section normal et invite."],
            ["employe","Employe","Ce rôle a accès à la section invite."],
        ];

        DB::table('Roles')->delete();
        foreach($items as $item) {
            $role = new Role();
            $role->name = $item[0];
            $role->display_name = $item[1];
            $role->description = $item[2];
            $role->save();
        }
    }
}