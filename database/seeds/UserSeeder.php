<?php

use Illuminate\Database\Seeder;

use App\User;

class UserTableSeeder extends Seeder {

    public function run()
    {
        $items = [
            //Nom, email, mot de passe
            ["Admin","admin@cegepdrummond.ca","Password1"],
            ["Responsable","responsable@cegepdrummond.ca","Password1"],
            ["Employe","employe@cegepdrummond.ca","Password1"]
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