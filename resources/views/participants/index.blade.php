@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des participants</h2>
		<a href="{{ action('ParticipantsController@create') }}" class="btn btn-info">Créer un participant</a>						
	</div>
@if ($participants->isEmpty())
	<div class="panel-body">
		<p>Aucun participant</p>
	</div>
@else
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Nom, Prenom</th>
				<th class="hidden-xs">Numéro</th>
				<th class="hidden-sm hidden-xs">Région</th>
				<th class="hidden-sm hidden-xs">Équipe</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
@foreach($participants as $participant)
			<tr>
				<td><a href="{{ action('ParticipantsController@show', $participant->id) }}">{{ $participant->nom }}, {{ $participant->prenom }}</a></td>
				<td class="hidden-xs">{{ $participant->numero }}</td>
				<td class="hidden-sm hidden-xs"><span data-toggle="tooltip" data-placement="bottom" title="{{ Region::where('id', '=', $participant->region_id)->get()[0]->nom }}">{{ Region::where('id', '=', $participant->region_id)->get()[0]->nom_court }}</span></td>
				<td class="hidden-sm hidden-xs"><?php if($participant->equipe) echo "Oui"; else echo "Non"; ?></td>
				<td><a href="{{ action('ParticipantsController@edit',$participant->id) }}" class="btn btn-info">Modifier</a></td>
				<td>{!! Form::open(array('action' => array('ParticipantsController@destroy',$participant->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
					<button type="submit" href="{{ URL::route('participants.destroy', $participant->id) }}" class="btn btn-danger btn-mini">Effacer</button>
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