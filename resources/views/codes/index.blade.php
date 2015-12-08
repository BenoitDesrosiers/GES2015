@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des codes</h2>
		<a href="{{ action('CodesController@create') }}" class="btn btn-info">Créer un code</a>
	</div>
@if ($codes->isEmpty())
	<div class="panel-body">
		<p>Aucun code</p>
	</div>
@else
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<!--  Les différents champs d'un code -->
				<th>Nom</th>
				<th class="hidden-xs">Abréviation</th>
				<th class="hidden-xs">Description</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<!--  Pour chaque code trouvé dans la base de données, affiche le nom, l'abréviation et la description  -->
@foreach($codes as $code)
			<tr>
				<td><a href="{{ action('CodesController@show', $code->id) }}">{{ $code->nom }}</a></td>
				<td class="hidden-xs"><?php echo $code->abreviation ?></td>
				<td class="hidden-xs"><?php echo $code->description ?></td>
				<td><a href="{{ action('CodesController@edit',$code->id) }}" class="btn btn-info">Modifier</a></td>
				<td>{!! Form::open(array('action' => array('CodesController@destroy',$code->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
					<button type="submit" href="{{ URL::route('codes.destroy', $code->id) }}" class="btn btn-danger btn-mini">Effacer</button>
					{!! Form::close() !!}   
				</td>
			</tr>
@endforeach
		</tbody>
	</table>
@endif
</div>
@stop