<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/','HomeController@index');
Route::get('/home','HomeController@index');
Route::get('/about','AboutController@index');

Auth::routes();

Route::group(['middleware'=>'auth'], function() {
	
	Route::resource('sports','SportsController');
	Route::resource('sports.epreuves','SportsEpreuvesController');
	Route::resource('sports.participants','sportParticipantController');
	Route::resource('sports.arbitres', 'SportsArbitresController');
	
	Route::get ( 'ajtParticipant/{epreuveId}', 'EpreuvesController@ajtParticipant' );
	Route::post ( 'storeParticipants/{epreuveId}', 'EpreuvesController@storeParticipants' );
	Route::get ( 'listeParticipant/{epreuveId}', 'EpreuvesController@listeParticipant' );
	
	Route::resource('epreuves','EpreuvesController');
	Route::resource('participants','ParticipantsController');
	Route::resource('resultats','ResultatsController');
	Route::resource('systeme', 'SystemeController');
	Route::resource('arbitres','ArbitresController');
	Route::resource('terrains','TerrainsController');
	Route::resource('equipes','EquipesController');
    Route::resource('benevoles','BenevolesController');
	Route::resource('roles','RolesController');
	Route::resource('codes','CodesController');
	
    Route::resource('disponibilites','DisponibilitesController');

	Route::post('pointagesPourSport', 'PointagesController@pointagesPourSport');
	Route::resource('pointages','PointagesController');

	Route::resource('delegues','DeleguesController');
	
	Route::post('epreuvesPourSport', 'EpreuvesController@epreuvesPourSport');
	Route::post('epreuvesPourSportResultats', 'ResultatsController@epreuvesPourSport');
	Route::post('evenementsPourEpreuveResultats', 'ResultatsController@evenementsPourEpreuve');
	Route::post('participants/recherche','ParticipantsController@recherche');
	Route::post('resultatPourEvenementResultats', 'ResultatsController@resultatPourEvenement');
    Route::resource('benevoles','BenevolesController');

	Route::resource('roles','RolesController');
   
});


