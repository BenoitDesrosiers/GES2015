@extends('layout')
@section('content')

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des tables de pointage</h2>
		<div class="row">
			<div class="col-md-6" id="bouton-créer">
				<a href="{{ action('PointagesController@create') }}" class="btn btn-info">Créer une table de pointage</a>
			</div> <!-- bouton créer -->
		</div>				

	</div>
	@if ($pointages->isEmpty())
		<div class="panel-body">
			<p>Aucune table de pointage</p>
		</div>
	@else
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Sport</th>
					<th class="col-sm-1 col-xs-1" />
					<th class="col-sm-1 col-xs-1" />
				</tr>
			</thead>
			<tbody>
				@foreach($pointages as $pointage)
					<tr>
						<td><a href="{{ action('PointagesController@show', $pointage->sport_id) }}">{{$pointage->sport->nom}}</a></td>
						<td><a href="{{ action('PointagesController@edit', $pointage->sport_id) }}" class="btn btn-info">Modifier</a></td>
						<td>
							{!! Form::open(array('action' => array('PointagesController@destroy',$pointage->sport_id), 'method' => 'delete', 'data-confirm' => 'Les données seront supprimées. Voulez-vous continuer?')) !!}
								<button type="submit" href="{{ URL::route('pointages.destroy', $pointage->sport_id) }}" class="btn btn-danger btn-mini">Effacer</button>
							{!! Form::close() !!}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
</div>
@stop