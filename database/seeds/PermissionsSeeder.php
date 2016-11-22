<?php


use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder {


    public function run()
    {
        $items = [
            //Name, Display_name, Description
            ["acces-eleve","Accès élevé","Cette permission permet d'avoir accès aux modules administrative."],
            ["acces-moyen","Accès moyen","Cette permission permet d'avoir accès aux modules de gestion. (Sauf administrative)"],
            ["acces-bas","Accès bas","Cette permission permet d'avoir accès aux modules de base."]
        ];

        DB::table('Permissions')->delete();

        foreach($items as $item) {
            $permission = new Permission();
            $permission->name = $item[0];
            $permission->display_name = $item[1];
            $permission->description = $item[2];
            $permission->save();
        }
    }
}