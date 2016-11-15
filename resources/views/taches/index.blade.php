@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des Tâches</h2>
		<a href="{{ action('TachesController@create') }}" class="btn btn-info">Créer une Tâche</a>						
	</div>
@if ($taches->isEmpty())
	<div class="panel-body">
		<p>Aucune tâche</p>
	</div>
@else
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Nom</th>
                <th class="hidden-xs">Description de la tâche</th>
                <th></th>
                <th></th>				
                <th></th>
			</tr>
		</thead>
		<tbody>
   @foreach($taches as $tache)
			<tr>
				<td><a href="{{ action('TachesController@show', $tache->id) }}">{{ $tache->nom }}</a></td>
                <td class="hidden-xs">{{ $tache->description }}</td>
                <td class="hidden-xs"></td>
                <td><a href="{{ action('TachesController@edit',$tache->id) }}" class="btn btn-info">Modifier</a></td>
				<td>{!! Form::open(array('action' => array('TachesController@destroy',$tache->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
					<button type="submit" href="{{ URL::route('taches.destroy', $tache->id) }}" class="btn btn-danger btn-mini">Effacer</button>
					{!! Form::close() !!}   {{-- méthode pour faire le delete tel que décrit sur http://www.codeforest.net/laravel-4-tutorial-part-2 , 
											un script js est appelé pour tous les form qui ont un "data-confirm" (voir assets/js/script.js) --}}
				</td>
                <td></td>
			</tr>
@endforeach
		</tbody>
	</table>
@endif
</div>
@stop
