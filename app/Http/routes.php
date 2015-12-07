<?php

use App\Http\Controllers\Auth\AuthController;

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

Route::group(['middleware'=>'auth'], function() {
	
	Route::resource('sports','SportsController');
	Route::resource('sports.epreuves','SportsEpreuvesController');
	
	Route::resource('sports.participants','sportParticipantController');
	
	Route::resource('epreuves','EpreuvesController');
	Route::resource('participants','ParticipantsController');
	Route::resource('resultats','ResultatsController');
	Route::resource('terrains','TerrainsController');
	
	Route::get('benevole/{id}', 'BenevolesController@showDisponibilites');

    Route::get('benevole/{id}/editDisponibilites', 'BenevolesController@editDisponibilites');
    Route::post('benevole/editDisponibilites/save', 'BenevolesController@editDisponibilitesSave');

	Route::post('epreuvesPourSport', 'EpreuvesController@epreuvesPourSport');
	Route::post('epreuvesPourSportResultats', 'ResultatsController@epreuvesPourSport');
	Route::post('evenementsPourEpreuveResultats', 'ResultatsController@evenementsPourEpreuve');
	Route::post('resultatPourEvenementResultats', 'ResultatsController@resultatPourEvenement');
    Route::resource('benevoles','BenevolesController');
	
	Route::resource('roles','RolesController');
   
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
	
	
/*	obsolete
 *
// Confide routes

Route::post('users', 'UsersController@store');
Route::get('users/create', 'UsersController@create');
Route::get('users/login', 'UsersController@login');
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');
*/
