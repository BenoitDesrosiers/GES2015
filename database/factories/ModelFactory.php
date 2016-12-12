<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
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
		'nom' => $faker->lastName,
		'tournoi' => 0,
		'saison' => 'h'
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

/**
 * Crée une ConditionParticuliere de test avec description.
 */
$factory->defineAs(App\Models\ConditionParticuliere::class, 'AvecDescription', function (Faker\Generator $faker) {
	return [
		'nom' => $faker->text(40),
		'description' => $faker->text(200)
	];
});

/**
 * Crée une ConditionParticuliere de test sans description.
 */
$factory->defineAs(App\Models\ConditionParticuliere::class, 'SansDescription', function (Faker\Generator $faker) {
	return [
		'nom' => $faker->text(40)
		];
});


$factory->define(App\Models\Cafeteria::class, function (Faker\Generator $faker){
	return  [
		'nom' => $faker->company,
		'adresse' => $faker->streetAddress,
		'localisation' => $faker->city,		
	];
});

$factory->define(App\Models\Responsable::class, function (Faker\Generator $faker){
	return [
		'nom' => $faker->name,
		// Le téléphone doit être 10 nombres collés et $faker->tollFreePhoneNumber ne 
		// retourne pas une valeur valide pour le système et 2147483647 sinon ça donne
		// une erreur sur Windows. 
		'telephone' => $faker->numberBetween(1000000000, 2147483647),
	];
});

$factory->define(App\Models\Contact::class, function (Faker\Generator $faker) {
	return [
			'prenom' => $faker->firstNameFemale,
			'nom'=> $faker->lastName,
			'telephone'=> $faker->tollFreePhoneNumber,
			'role' => $faker->jobTitle,
			'organisme_id' => factory(App\Models\Organisme::class)->create()->id
	];
});

$factory->define(App\Models\Organisme::class, function (Faker\Generator $faker) {
	return [
			'nomOrganisme' => $faker->company,
			'telephone'=> $faker->tollFreePhoneNumber,
			'description'=> $faker->catchPhrase,
	];
});
