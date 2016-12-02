@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des associations</h2>
		<a href="{{ action('AssociationsController@create') }}" class="btn btn-info">Créer une association</a>
	</div>
@if ($associations->isEmpty())
	<div class="panel-body">
		<p>Aucune association</p>
	</div>
@else
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<!--  Les différents champs d'une association -->
				<th>Nom</th>
				<th class="hidden-xs">Abréviation</th>
				<th class="hidden-xs">Description</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<!--  Pour chaque association trouvée dans la base de données, affiche le nom, l'abréviation et la description  -->
@foreach($associations as $association)
			<tr>
				<td><a href="{{ action('AssociationsController@show', $association->id) }}">{{ $association->nom }}</a></td>
				<td class="hidden-xs"><?php echo $association->abreviation ?></td>
				<td class="hidden-xs"><?php echo $association->description ?></td>
				<td><a href="{{ action('AssociationsController@edit',$association->id) }}" class="btn btn-info">Modifier</a></td>
				<td>{!! Form::open(array('action' => array('AssociationsController@destroy',$association->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
					<button type="submit" href="{{ URL::route('associations.destroy', $association->id) }}" class="btn btn-danger btn-mini">Effacer</button>
					{!! Form::close() !!}   
				</td>
			</tr>
@endforeach
		</tbody>
	</table>
@endif
</div>
@stop