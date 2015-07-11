@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des épreuves pour {{ $sport->nom }}</h2>
		<a href="{{ action('SportsEpreuvesController@create', $sport->id) }}" class="btn btn-info">Créer une épreuve</a>	
	</div>
@if ($epreuves->isEmpty())
	<div class="panel-body">
		<p>Aucun épreuves disponibles!</p>
	</div>
@else
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Nom</th>
				<th class="hidden-xs">Description</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
@foreach($epreuves as $epreuve)
			<tr>
				<td><a href="{{ action('SportsEpreuvesController@show', [$sport->id, $epreuve->id]) }}">{{ $epreuve->nom }}</a></td>
				<td class="hidden-xs"><?php if ($epreuve->description == "") {echo "Aucune description";} else {echo $epreuve->description;} ?></td>
				<td><a href="{{ action('SportsEpreuvesController@edit', [$sport->id, $epreuve->id]) }}" class="btn btn-info">Modifier</a></td>
				<td>{!! Form::open(array('action' => array('SportsEpreuvesController@destroy',$sport->id, $epreuve->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
					<button type="submit" href="{{ URL::route('sports.epreuves.destroy', $sport->id, $epreuve->id) }}" class="btn btn-danger btn-mini">Effacer</button>
					{!! Form::close() !!}
				</td>
			</tr>
@endforeach
		</tbody>
	</table>
@endif
</div>
@stop