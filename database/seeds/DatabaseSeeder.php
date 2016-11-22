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
        $this->call('RolesSeeder');
        $this->call('UsersRolesSeederTable');
        $this->call('PermissionsSeeder');
        $this->call('PermissionsRolesSeederTable');
		$this->call('SportsTableSeeder');
        $this->call('TypesEvenementTableSeeder');
        $this->call('EpreuvesTableSeeder');
		$this->call('RegionsTableSeeder');
		$this->call('ParticipantsTableSeeder');
		$this->call('EquipesSeeder');
		$this->call('ArbitresTableSeeder');
		$this->call('info_event');
		$this->call('TerrainsTableSeeder');
        $this->call('EvenementsTableSeeder');
        $this->call('BenevolesTableSeeder');
        $this->call('DisponibilitesTableSeeder');
        $this->call('RolesPourDeleguesTableSeeder');
		$this->call('PointagesTableSeeder');
		$this->call('DeleguesTableSeeder');
		$this->call('DeleguesRolesPourDeleguesTableSeeder');
		$this->call('TachesTableSeeder');
		$this->call('ConditionsParticulieresSeeder');
		//$this->call('ResultatTournoisTableSeeder');
		
		Model::reguard();
		
	}

}
