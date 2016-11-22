@extends('layout')
@section('content')
	<!-- Jumbotron -->
	<div class="jumbotron">
		<h1><?php echo $titre ?></h1>
		<p class="lead">Bienvenue dans le système de gestion des résultats</p>
		<p><a class="btn btn-lg btn-success" href="{{ action('SportsController@index') }}" role="button">Sports</a>
		<a class="btn btn-lg btn-success" href="{{ action('EpreuvesController@index') }}" role="button">Épreuves</a>
		<a class="btn btn-lg btn-success" href="{{ action('OrganismesController@index') }}" role="button">Organismes</a>
		<a class="btn btn-lg btn-success" href="{{ action('ParticipantsController@index') }}" role="button">Participants</a>
		<a class="btn btn-lg btn-success" href="{{ action('EquipesController@index') }}" role="button">Équipes</a></p>
		<p><a class="btn btn-lg btn-success" href="{{ action('ResultatsController@index') }}" role="button">Résultats</a>
		<a class="btn btn-lg btn-success" href="{{ action('SystemeController@index') }}" role="button">Système</a></p>
		<a class="btn btn-lg btn-success" href="{{ action('BenevolesController@index') }}" role="button">Bénévoles</a>
		<a class="btn btn-lg btn-success" href="{{ action('TachesController@index') }}" role="button">Tâches</a>
		<a class="btn btn-lg btn-success" href="{{ action('ArbitresController@index') }}" role="button">Arbitres</a>
		<a class="btn btn-lg btn-success" href="{{ action('DeleguesController@index') }}" role="button">Délégués</a>
		<a class="btn btn-lg btn-success" href="{{ action('RolesController@index') }}" role="button">Rôles</a></p>
		<a class="btn btn-lg btn-success" href="{{ action('PointagesController@index') }}" role="button">Pointages</a></p>
		<a class="btn btn-lg btn-success" href="{{ action('TerrainsController@index') }}" role="button">Terrains</a></p>
		<a class="btn btn-lg btn-success" href="{{ action('EvenementsController@index') }}" role="button">Événements</a></p>
		<a class="btn btn-lg btn-success" href="{{ action('CodesController@index') }}" role="button">Codes</a></p>	
		<a class="btn btn-lg btn-success" href="{{ action('AboutController@index') }}" role="button">À propos</a></p>

	</div>
	<?php phpinfo();?>
@stop
