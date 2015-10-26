@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $arbitre->nom }}, {{ $arbitre->prenom }}</h2>
	</div>
	<div class="panel-body">
		<p>Région: {{ $region->nom }}</p>
		<p>Numéro: {{ $arbitre->numero_accreditation }}</p>
		<p>Association: {{ $arbitre->association }}</p>
		<p>Numéro de téléphone: {{ $arbitre->association }}</p>
		<p>Adresse: {{ $arbitre->adresse }}</p>
		<p>Sexe: {{ $arbitre->sexe }}</p>
		<p>Date de naissance: {{ $arbitre->date_naissance }}</p>
	</div>
</div>
@stop