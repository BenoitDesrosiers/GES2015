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
                <th class="hidden-sm hidden-xs"></th>
                <th class="hidden-xs">Accréditation</th>
                <th class="hidden-xs">Vérification</th>
                <th></th>				
                <th></th>
			</tr>
		</thead>
		<tbody>
@foreach($benevoles as $benevole)
			<tr>
				<td><a href="{{ action('BenevolesController@show', $benevole->id) }}">{{ $benevole->nom }}, {{ $benevole->prenom }}</a></td>
                <!--Bouton qui ne fait strictement rien! Préparation en vue de ma deuxième fonctionnalité : Associer des disponibilités à un bénévole.-->
                <td class="hidden-sm hidden-xs"><a href="{{ action('DisponibilitesController@show',$benevole->id) }}" class="btn btn-info">Disponibilités</a></td>
                <td class="hidden-xs">{{ $benevole->accreditation }}</td>
                <td class="hidden-xs">{{ $benevole->verification }}</td>
                <td><a href="{{ action('BenevolesController@edit',$benevole->id) }}" class="btn btn-info">Modifier</a></td>
				<td>{!! Form::open(array('action' => array('BenevolesController@destroy',$benevole->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
					<button type="submit" href="{{ URL::route('benevoles.destroy', $benevole->id) }}" class="btn btn-danger btn-mini">Effacer</button>
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
