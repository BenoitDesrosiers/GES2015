<?php

use Illuminate\Database\Seeder;

use App\User;

class UserTableSeeder extends Seeder {

    public function run()
    {
        $items = [
            //Nom, email, mot de passe
            ["Admin","admin@cegepdrummond.ca","password"],
            ["Responsable","responsable@cegepdrummond.ca","password"],
            ["Employe","employe@cegepdrummond.ca","password"]
        ];


        DB::table('users')->delete();
        DB::table('password_resets')->delete();
        foreach ($items as $item){
            $user = new User();
            $user->name = $item[0];
            $user->email = $item[1];
            $user->password = Hash::make($item[2]);
            $user->save();
        }
    }
}