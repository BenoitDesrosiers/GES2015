@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des Bénévoles</h2>
		<a href="{{ action('BenevolesController@create') }}" class="btn btn-info">Créer un bénévole</a>						
	</div>
@if ($benevoles->isEmpty())
	<div class="panel-body">
		<p>Aucun bénévole</p>
	</div>
@else
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Nom</th>
				<th class="hidden-xs">Adresse</th>
				<th class="hidden-xs">Numéro de Téléphone</th>
				<th class="hidden-sm hidden-xs">Numéro de Cellulaire</th>
				<th class="hidden-sm hidden-xs">Courriel</th>
				<th class="hidden-xs">Disponibilité</th>
                <th class="hidden-xs">Accréditation</th>
                <th class="hidden-xs">Vérification</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
@foreach($benevoles as $benevole)
			<tr>
				<td><a href="{{ action('BenevolesController@show', $benevole->id) }}">{{ $benevole->nom }}</a></td>

			</tr>
@endforeach
		</tbody>
	</table>
@endif
</div>
@stop
