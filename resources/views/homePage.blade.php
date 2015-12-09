@extends('layout')
@section('content')
	<!-- Jumbotron -->
	<div class="jumbotron">
		<h1><?php echo $titre ?></h1>
		<p class="lead">Bienvenue dans le système de gestion des résultats</p>
		<p><a class="btn btn-lg btn-success" href="{{ action('SportsController@index') }}" role="button">Sports</a>
		<a class="btn btn-lg btn-success" href="{{ action('EpreuvesController@index') }}" role="button">Épreuves</a>
		<a class="btn btn-lg btn-success" href="{{ action('ParticipantsController@index') }}" role="button">Participants</a></p>
		<a class="btn btn-lg btn-success" href="{{ action('ResultatsController@index') }}" role="button">Résultats</a></p>
		<a class="btn btn-lg btn-success" href="{{ action('SystemeController@index') }}" role="button">Système</a></p>
		<a class="btn btn-lg btn-success" href="{{ action('BenevolesController@index') }}" role="button">Bénévoles</a>
		<a class="btn btn-lg btn-success" href="{{ action('ArbitresController@index') }}" role="button">Arbitres</a>
		<a class="btn btn-lg btn-success" href="{{ action('RolesController@index') }}" role="button">Rôles</a></p>
		<a class="btn btn-lg btn-success" href="{{ action('TerrainsController@index') }}" role="button">Terrains</a></p>
		<a class="btn btn-lg btn-success" href="{{ action('AboutController@index') }}" role="button">À propos</a></p>
	</div>
@stop
