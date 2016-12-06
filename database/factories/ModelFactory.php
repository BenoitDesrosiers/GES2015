<?php

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
		// Le téléphone doit être 10 nombres collés. 
		'telephone' => $faker->numberBetween(1000000000, 9999999999),
	];
});
