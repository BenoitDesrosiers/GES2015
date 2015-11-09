@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title"><a href="{{ action('BenevolesController@index', $benevole->id) }}"><- {{ $benevole->nom }}, {{ $benevole->prenom }}</a></h2>
	</div>
	<div class="panel-body">
		<p>Adresse : {{ $benevole->adresse }}</p>
		<p>Numéro de Téléphone : {{ $benevole->numTel }}</p>
        <p>Numéro de Cellulaire : {{ $benevole->numCell }}</p>
        <p>Courriel : {{ $benevole->courriel }}</p>
        <p>Accréditation : {{ $benevole->accreditation }}</p>
        <p>Vérification : {{ $benevole->verification }}</p>
	</div>
</div>
@stop
