<?php

use App\Models\Adresse;
use App\Models\Telephone;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Participant;
use App\Models\Region;
use App\Models\Sport;


class ParticipantsTableSeeder extends Seeder {

/**
 * Crée les entrées de la table Participants correspondant aux équipes
 */
public function run()
{
	//TODO: à refaire car ca plante si on seed 2 fois car les id de région et de sports sont hardcodés
	$entrees = [
		//prénom,	nom				#, region,sport,sexe
		["Arthur"	, "Archambault"	, 1,	1,	1,	0],
		["Beowulf"	, "Beaulieu"	, 2,	1,	2,	0],
		["Circé"	, "Charron"		, 3,	1,	3,	1],
		["Donatello", "DeGrandPré"	, 4,	2,	1,	0],
		["Elsa"		, "Eiffel"		, 5,	2,	2,	1],
		["Francesco", "Funiculaire"	, 6,	2,	3,	0],
		["Ginette"	, "Gargantua"	, 7,	3,	1,	1],
		["Henri"	, "Hippocampe"	, 8,	3,	2,	0],
		["Ivan"		, "Impitoyable"	, 9,	3,	3,	0],
		["Josephte" , "Jamboni"		,10,	4,	1,	1],
		["Kitty" 	, "KitKat"		,11,	4,	2,	1],
		["Lola"		, "Lilalou"		,12,	4,	3,	1],
		["Manon" 	, "Moriarty"	,13,	5,	1,	1],
		["Norbert"	, "Nucléaire"	,14,	5,	2,	0],
		["Osiris"	, "Orangeraie"	,15,	5,	3,	0],
		["Patricia" , "Pédoncule"	,16,	6,	1,	1],
		["Quetzal"	, "Quelconque"	,17,	6,	2,	0],
		["Rosa"		, "Rubéole"		,18,	6,	3,	1],
		["Stephen"	, "Satan"		,19,	1,	1,	0],
		["Tarantula", "Tantrique"	,20,	2,	2,	1],
		["Ursulin"	, "Ultime Ninja",21,	3,	3,	0],
		["Vanessa"	, "Velociraptor",22,	4,	1,	1],
		["Waldorf"	, "Wolfenstein"	,23,	5,	2,	0],
		["Xanetia"	, "Xylophage"	,24,	6,	3,	1],
		["Yannick"	, "Ytterbium"	,25,	1,	4,	0],
		["Zaza"		, "Zébulon"		,26,	2,	4,	1]
	];
	
	$sports = Sport::all();
	$regions = Region::all();

	Participant::where('equipe','=',0)->delete();

	foreach($entrees as $entree) {
		$participant = new Participant;
		$participant->prenom = $entree[0];
		$participant->nom = $entree[1];
		$participant->numero = $entree[2];
		$participant->region_id = $regions[$entree[3]]->id;
		$participant->sexe = $entree[5];
		$participant->naissance = new DateTime;
		$participant->equipe = false;
		$participant->save();
		$participant->sports()->attach([$sports[$entree[4]]->id]);

		$telephone = New Telephone;
		$telephone->numero = strval(rand(1000000000, 2000000000));
		$telephone->description = str_random(10);
		$telephone->participant()->associate($participant);
		$telephone->save();

		$adresse = New Adresse;
		$adresse->adresse = rand(1,5000) . ", rue " . str_random(10);
		$adresse->description = str_random(10);
		$adresse->participant()->associate($participant);
		$adresse->save();

		$adresse2 = New Adresse;
		$adresse2->adresse = rand(1,5000) . ", rue " . str_random(10);
		$adresse2->description = str_random(10);
		$adresse2->participant()->associate($participant);
		$adresse2->save();
	}
}

}
