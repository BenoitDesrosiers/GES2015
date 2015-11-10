@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des rôles</h2>
		<a href="{{ action('RolesController@create') }}" class="btn btn-info">Créer un rôle</a>
	</div>
@if ($roles->isEmpty())
	<div class="panel-body">
		<p>Aucun rôle</p>
	</div>
@else
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Nom</th>
				<th class="hidden-xs">Description</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
@foreach($roles as $role)
			<tr>
				<td><a href="{{ action('RolesController@show', $role->id) }}">{{ $role->nom }}</a></td>
				<td class="hidden-xs"><?php echo $role->description ?></td>
				<td><a href="{{ action('RolesController@edit',$role->id) }}" class="btn btn-info">Modifier</a></td>
				<td>{!! Form::open(array('action' => array('RolesController@destroy',$role->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
					<button type="submit" href="{{ URL::route('roles.destroy', $role->id) }}" class="btn btn-danger btn-mini">Effacer</button>
					{!! Form::close() !!}   {{-- méthode pour faire le delete tel que décrit sur http://www.codeforest.net/laravel-4-tutorial-part-2 , 
											un script js est appelé pour tous les form qui ont un "data-confirm" (voir assets/js/script.js) --}}
				</td>
			</tr>
@endforeach
		</tbody>
	</table>
@endif
</div>
@stop