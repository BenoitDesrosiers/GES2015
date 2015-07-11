@extends('layout')
@section('content')
<div class="jumbotron">
	<h1> Une erreur s'est produite.</h1>
	<p>{{$e->getMessage()}}</p>
	<a href="{{ action('HomeController@index') }}" class="btn btn-info">Retour à l'accueil</a>					
</div>
@stop