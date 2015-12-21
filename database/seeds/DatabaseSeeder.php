<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	
	/*
	 * IMPORTANT 
	 * lors de l'ajout d'un nouveau seeder, il faut exécuter "composer dump-autoload"
	 * sinon, vous risquez d'avoir l'erreur "Cannot redeclare class DatabaseSeeder".
	 */
	public function run() 
	{
        Model::unguard();
		
		$this->call('UserTableSeeder');
		$this->call('SportsTableSeeder');
		$this->call('EpreuvesTableSeeder');
		$this->call('RegionsTableSeeder');
		$this->call('ParticipantsTableSeeder');
		$this->call('EquipesSeeder');
		$this->call('ArbitresTableSeeder');
		$this->call('EvenementsTableSeeder');
		$this->call('info_event');
		$this->call('TerrainsTableSeeder');
        $this->call('BenevolesTableSeeder');
        $this->call('DisponibilitesTableSeeder');
		$this->call('RolesTableSeeder');
		//$this->call('ResultatTournoisTableSeeder');
		
		Model::reguard();
		
	}

}

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();
		DB::table('password_resets')->delete();
		$user = new User();
		$user->name = 'usager';
		$user->email = 'usager@chose.com';
		$user->password = Hash::make('usager');
		$user->save();
	}
}
