<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Equipe;
use App\Models\Participant;
use App\Models\Region;
use App\Models\Sport;

class EquipesSeeder extends Seeder {

public function run()
{
	$this->creerEquipes();
}

/**
 * Crée les entrées de la table Participants correspondant aux équipes
 */
public function creerEquipes() {
	$entrees = [
		//nom,				 		  	#, region,sport, membres
		["Grizzlis effarouchés"			, 1,	1,	1,	[ 1, 2, 3]],
		["Opossums déchaînés"			, 2,	1,	2,	[ 4, 5, 6]],
		["Antilopes frustrées"			, 3,	1,	3,	[ 7, 8, 9]],
		["Nasiques offensés"			, 4,	2,	1,	[]],
		["Renards désinhibés"			, 5,	2,	1,	[13,14,15]],
		["Escargots enragés"			, 6,	2,	3,	[16,18,19]],
		["Méduses surexcitées"			, 7,	3,	2,	[20,21,22]],
		["Gousses d'aïl en furie"		, 8,	3,	1,	[24,25,26]],
		["Levures passives-agressives"	, 9,	5,	3,	[ 1, 2, 3]],
		["Streptocoques désagréables"	,10,	4,	3,	[ 4, 5, 6]],
	];

	$sports = Sport::all();
	$regions = Region::all();
	$participants = Participant::all();
	
	Equipe::where('equipe','=',1)->delete();
	
	foreach($entrees as $entree) {
		$equipe = new Equipe;
		$equipe->nom = $entree[0];
		$equipe->numero = $entree[1];
		$equipe->region_id = $regions[$entree[2]]->id;
		$equipe->prenom = "";
		$equipe->equipe = true;
		$equipe->sexe = $entree[1] % 2;
		$equipe->naissance = new DateTime;
		$equipe->save();
		$equipe->sports()->attach([$sports[$entree[3]]->id]);
		$index_membres = array();
		for ($x = 0; $x < count($entree[4]); $x++) {
			array_push($index_membres, $participants[$entree[4][$x]-1]->id);
		}
		$equipe->membres()->sync($index_membres);
	}
}


}