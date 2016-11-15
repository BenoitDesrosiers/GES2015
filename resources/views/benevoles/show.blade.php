@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title"><a href="{{ action('BenevolesController@index', $benevole->id) }}">Liste <- {{ $benevole->nom }}, {{ $benevole->prenom }}</a></h2>
	</div>
	<div class="panel-body">
		<p>Adresse : {{ $benevole->adresse }}</p>
		<p>Numéro de Téléphone : {{ $benevole->numTel }}</p>
        <p>Numéro de Cellulaire : {{ $benevole->numCell }}</p>
        <p>Courriel : {{ $benevole->courriel }}</p>
        <p><a href="{{ action('DisponibilitesController@show',$benevole->id) }}" class="btn btn-info">Afficher Disponibilités</a></p>
        <p>Accréditation : {{ $benevole->accreditation }}</p>
        <p>Vérification : {{ $benevole->verification }}</p>
        
        <!--    Afficher les sports du bénévole      -->
		@if (!$benevole->sports->isEmpty())
			<p>Sports:</p>
			<ul>
				@foreach ($benevole->sports as $sport)
					<li>
						<a href="{!! action('SportsController@show', $sport->id) !!}">
							{!!$sport->nom!!}
						</a>
					</li>
				@endforeach
			</ul>
        @endif
        
	</div>
</div>
@stop