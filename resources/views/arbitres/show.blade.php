@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $arbitre->nom }}, {{ $arbitre->prenom }}</h2>
	</div>
	<div class="panel-body">
		<p>Région : {{ $region->nom }}</p>
		<p>Numéro : {{ $arbitre->numero_accreditation }}</p>
		<p>Association : {{ $arbitre->association }}</p>
		<p>Sexe :
	        @if ($participant->sexe)
	            Masculin
	        @else
	            Féminin
	        @endif
        </p>
		<p>Numéro de téléphone : {{ $arbitre->numero_telephone }}</p>
		@if ($participant->adresse)
			<p>Adresse : {{ $arbitre->adresse }}</p>
		@endif

   		@if ($arbitre->date_naissance)
   			<p>Date de naissance : {{ $arbitre->date_naissance }}</p>
   		@endif
	</div>
</div>
@stop