@extends('layout')
@section('content')
<?php use App\Models\Region; //TODO: enlever le code qui accède directement à Région de la view, et passer les régions en paramètre, une fois fait, enlever cette ligne?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des arbitres</h2>
		<a href="{{ action('ArbitresController@create') }}" class="btn btn-info">Créer un arbitre</a>						
	</div>
	@if ($arbitres->isEmpty())
		<div class="panel-body">
			<p>Aucun arbitre</p>
		</div>
	@else
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Nom, Prenom</th>
					<th class="hidden-xs">Région</th>
					<th class="hidden-sm hidden-xs">Numéro d'accréditation</th>
					<th class="hidden-sm hidden-xs">Association</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($arbitres as $arbitre)
					<tr>
						<td><a href="{{ action('ArbitresController@show', $arbitre->id) }}">{{ $arbitre->nom }}, {{ $arbitre->prenom }}</a></td>
						<td class="hidden-xs"><span data-toggle="tooltip" data-placement="bottom" title="{{ Region::where('id', '=', $arbitre->region_id)->get()[0]->nom }}">{{ Region::where('id', '=', $arbitre->region_id)->get()[0]->nom_court }}</span></td>
						<td class="hidden-sm hidden-xs">{{ $arbitre->numero_accreditation }}</td>
						<td class="hidden-sm hidden-xs">{{ $arbitre->association }}</td>
						<td><a href="{{ action('ArbitresController@edit',$arbitre->id) }}" class="btn btn-info">Modifier</a></td>
						<td>{!! Form::open(array('action' => array('ArbitresController@destroy',$arbitre->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
							<button type="submit" href="{{ URL::route('arbitres.destroy', $arbitre->id) }}" class="btn btn-danger btn-mini">Effacer</button>
							{!! Form::close() !!}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<script>
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			})
		</script>
	@endif
</div>
@stop