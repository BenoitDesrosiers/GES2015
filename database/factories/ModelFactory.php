<?php

use App\Models\Region;
use App\Models\Terrain;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});
		
$factory->define(App\Models\Participant::class, function (Faker\Generator $faker) {
	return [
		'nom' => $faker->lastName,
		'prenom' => $faker->firstName,
		'region_id' => factory(App\Models\Region::class)->create()->id,
		'equipe' => 0,
        'numero' => $faker->numberBetween(1,99),
		'sexe' => $faker->numberBetween(0,1),
		'naissance' => $faker->date()
	];
});

$factory->define(App\Models\Region::class, function (Faker\Generator $faker) {
	return [
		'nom' => $faker->city,
        'nom_court' => $faker->citySuffix
	];
});

$factory->define(App\Models\Sport::class, function (Faker\Generator $faker) {
    return [
        'nom' => $faker->jobTitle, // Pas rapport, mais il n'y avait pas de nom de sport...
        'tournoi' => 0,
        'saison' => 'e'
    ];
});

//Pour les tests 'TerrainsEpreuvesTest'
$factory->define(App\Models\Epreuve::class, function (Faker\Generator $faker) {
	return [
			'nom' => 'Simple Masculin'
	];
});

$factory->define(App\Models\TypeEvenement::class, function (Faker\Generator $faker) {
    return [
        'titre' => $faker->text(20)
    ];
});

$factory->define(App\Models\Evenement::class, function (Faker\Generator $faker) {
    return [
        'nom' => $faker->text(20),
        'type_id' => factory(App\Models\TypeEvenement::class)->create()->id,
        'date_heure' => $faker->date('Y-m-d G:i'),
        'epreuve_id' => factory(App\Models\Epreuve::class)->create()->id
    ];
});

$factory->define(App\Models\Terrain::class, function (Faker\Generator $faker) {
	return [
			'nom' => 'Simple Masculin',
			'adresse'=> $faker->address,
			'ville'=> $faker->city,
			'region_id' => rand(0, 100)
	];
});
