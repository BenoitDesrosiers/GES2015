@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $benevole->nom}}, {{$benevole->prenom }}</h2>
	</div>
	<div class="panel-body">
		<p>Adresse : {{ $benevole->adresse }}</p>
		<p>Numéro de Téléphone : {{ $benevole->numTel }}</p>
        <p>Numéro de Cellulaire : {{ $benevole->numCell }}</p>
        <p>Courriel : {{ $benevole->courriel }}</p>
        <!--Bouton qui ne fait strictement rien! Préparation en vue de ma deuxième fonctionnalité : Associer des disponibilités à un bénévole.-->
        <p><a href="{{ action('BenevolesController@show',$benevole->id) }}" class="btn btn-info">Disponibilités</a></p>
        <p>Accréditation : {{ $benevole->accreditation }}</p>
        <p>Vérification : {{ $benevole->verification }}</p>
	</div>
</div>
@stop
