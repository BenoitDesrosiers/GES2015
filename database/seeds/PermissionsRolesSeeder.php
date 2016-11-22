<?php
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionsRolesSeederTable extends Seeder
{
    public function run(){


        $items = [
            //roles_id, permission_id
            [0,[0,1,2]],[1,[1,2]],[2,[2]]
        ];

        $roles = Role::all();

        $permissions = Permission::all();

        DB::table('permission_role')->delete();

        foreach($items as $item) {
            $groupe_Permissions = $item[1];
            foreach($groupe_Permissions as $permission){
                $roles[$item[0]]->Permissions()->attach($permissions[$permission]);
            }
        }
    }
}