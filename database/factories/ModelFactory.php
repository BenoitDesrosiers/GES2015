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


$factory->define(App\Models\Organisme::class, function (Faker\Generator $faker) {
    return [
        'nomOrganisme' => $faker->name,
        'telephone' => $faker->tollFreePhoneNumber,
        'description' => $faker->sentence
    ];
});
		
$factory->define(App\Models\Participant::class, function (Faker\Generator $faker) {
	return [
		'nom' => $faker->lastName,
		'prenom' => $faker->firstName,
		'region_id' => factory(App\Models\Region::class)->create()->id,
		'equipe' => 0,
		'sexe' => $faker->numberBetween(0,1),
		'naissance' => $faker->date()
	];
});

$factory->define(App\Models\Region::class, function (Faker\Generator $faker) {
	return [
        'nom' => $faker->name,
        'nom_court' => $faker->name,
        'or' => null,
        'argent' => null,
        'bronze' => null,
        'points' => null,
        'url_logo' => ""
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

$factory->define(App\Models\Terrain::class, function (Faker\Generator $faker) {
	return [
			'nom' => 'Simple Masculin',
			'adresse'=> $faker->address,
			'ville'=> $faker->city,
			'region_id' => rand(0, 100)
	];
});

$factory->define(App\Models\Delegue::class, function (Faker\Generator $faker) {
    return [
        'nom' => $faker->name,
        'prenom' => $faker->name,
        'region_id' => factory(App\Models\Region::class)->create()->id,
        'role_id' => 0,
        'accreditation' => rand(0,1),
        'sexe' => rand(0,1),
        'date_naissance' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'adresse' => $faker->address
    ];
});

