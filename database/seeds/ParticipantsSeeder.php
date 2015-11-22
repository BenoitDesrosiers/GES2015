<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Participant;

class ParticipantsTableSeeder extends Seeder {

public function run()
{
	$this->creerParticipants();
}

/**
 * Crée les entrées de la table Participants correspondant aux équipes
 */
public function creerParticipants() {
	$entrees = [
		//prénom,	nom				#, region,sport,sexe
		["Arthur"	, "Archambault"	, 1,	1,	1,	1],
		["Beowulf"	, "Beaulieu"	, 2,	1,	2,	1],
		["Circé"	, "Charron"		, 3,	1,	3,	0],
		["Donatello", "DeGrandPré"	, 4,	2,	1,	1],
		["Elsa"		, "Eiffel"		, 5,	2,	2,	0],
		["Francesco", "Funiculaire"	, 6,	2,	3,	1],
		["Ginette"	, "Gargantua"	, 7,	3,	1,	0],
		["Henri"	, "Salvador"	, 8,	3,	2,	1],
		["Ivan"		, "Impitoyable"	, 9,	3,	3,	1],
		["Josephte" , "Jamboni"		,10,	4,	1,	0],
		["Kitty" 	, "KitKat"		,11,	4,	2,	0],
		["Lola"		, "Lilalou"		,12,	4,	3,	0],
		["Manon" 	, "Moriarty"	,13,	5,	1,	0],
		["Norbert"	, "Nucléaire"	,14,	5,	2,	1],
		["Osiris"	, "Orangeraie"	,15,	5,	3,	1],
		["Patricia" , "Pédoncule"	,16,	6,	1,	0],
		["Quetzal"	, "Quelconque"	,17,	6,	2,	1],
		["Rosa"		, "Rubéole"		,18,	6,	3,	0],
		["Stephen"	, "Satan"		,19,	1,	1,	1],
		["Tarantula", "Tantrique"	,20,	2,	2,	0],
		["Ursulin"	, "Ultime Ninja",21,	3,	3,	1],
		["Vanessa"	, "Velociraptor",22,	4,	1,	0],
		["Waldorf"	, "Wolfenstein"	,23,	5,	2,	1],
		["Xanetia"	, "Xylophage"	,24,	6,	3,	0],
		["Yannick"	, "Ytterbium"	,25,	1,	4,	1],
		["Zaza"		, "Zébulon"		,26,	2,	4,	0],
	];

	Participant::where('equipe','=',0)->delete();
	foreach($entrees as $entree) {
		$participant = new Participant;
		$participant->prenom = $entree[0];
		$participant->nom = $entree[1];
		$participant->numero = $entree[2];
		$participant->region_id = $entree[3];
		$participant->sexe = $entree[5];
		$participant->naissance = new DateTime;
		$participant->equipe = false;
		$participant->save();
		$participant->sports()->attach([$entree[4]]);
	}
}

}