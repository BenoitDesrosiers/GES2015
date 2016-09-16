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


$factory->define(App\Models\Benevole::class, function (Faker\Generator $faker) {
		return [
				'nom' => $faker->name,
				'prenom' => $faker->name,
				'adresse' => str_random(10),
				'numTel' => str_random(10),
				'numCell' => $faker->phoneNumber(),
				'courriel' => str_random(10),
				'accreditation' => str_random(10),
				'verification' => 'A faire',
				'date_naissance' => $faker->DateTimeThisCentury(),
				'sexe' => 'h'
				
				];
	});
	
$factory->define(App\Models\Equipe::class, function(Faker\Generator $faker) {
	
	$regions_id = DB::table('regions')->select('id')->get();
	
	return [
	 		'nom' => $faker->name,
			'prenom' => $faker->name,
			'numero' => rand(1,1000),
			'region_id' => $faker->randomElement($regions_id)->id,
			'or' => rand(0,3),
			'argent' => rand(0,2),
			'bronze' => rand(0,5),
			'points' => rand(0,100),
			'equipe' => true,
			'sexe' => $faker->boolean(),
			'naissance' => $faker->DateTimeThisCentury(),
			'adresse' => $faker->streetAddress(),
			'nom_parent' => $faker->name(),
			'telephone' => $faker->phoneNumber(), 
 				
			
	   	   ];	
});






