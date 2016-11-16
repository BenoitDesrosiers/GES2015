@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title"><a href="{{ action('TachesController@index', $tache->id) }}">La tâche : {{ $tache->nom }}</a></h2>
	</div>
	<div class="panel-body">
		<p>Nom : {{ $tache->nom }}</p>
		<p>Description : {{ $tache->description }}</p>

	</div>
</div>
@stop
