@extends('layout')
@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des Sports</h2>
		<a href="{{ action('SportsController@create') }}" class="btn btn-info">Créer un sport</a>						
	</div>
@if ($sports->isEmpty())
	<div class="panel-body">
		<p>Aucun sport</p>
	</div>
@else
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Nom</th>
				<th class="hidden-xs">Saison</th>
				<th class="hidden-xs">Description</th>
				<th class="hidden-sm hidden-xs">Logo</th>
				<th class="hidden-sm hidden-xs">Page officielle</th>
				<th class="hidden-xs">Tournoi</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
@foreach($sports as $sport)
			<tr>
				<td><a href="{{ action('SportsController@show', $sport->id) }}">{{ $sport->nom }}</a></td>
				<td class="hidden-xs"><?php if ($sport->saison == "h") { echo "Hiver";} else {echo "Été";} ?></td>
				<td class="hidden-xs"><?php if ($sport->description_courte == "") {echo "Aucune description";} else {echo $sport->description_courte;} ?></td>
				<td class="hidden-sm hidden-xs"><img src="{{ $sport->url_logo }}" alt="Logo du sport"/></td>
				<td class="hidden-sm hidden-xs"><a href="{{ $sport->url_page_officielle }}">Lien</a></td>
				<td class="hidden-xs"><?php if ($sport->tournoi == 1) {echo "Oui";} else {echo "Non";} ?></td>
				<td><a href="{{ action('SportsController@edit',$sport->id) }}" class="btn btn-info">Modifier</a></td>
				<td>{!! Form::open(array('action' => array('SportsController@destroy',$sport->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
					<button type="submit" href="{{ URL::route('sports.destroy', $sport->id) }}" class="btn btn-danger btn-mini">Effacer</button>
					{!! Form::close() !!}   {{-- méthode pour faire le delete tel que décrit sur http://www.codeforest.net/laravel-4-tutorial-part-2 , 
											un script js est appelé pour tous les form qui ont un "data-confirm" (voir assets/js/script.js) --}}
				</td>
				<td><a href="{{ action('SportsEpreuvesController@index',$sport->id ) }}" class="btn btn-info">Épreuves</a></td>
				
          		<td><a href="{{ action('sportParticipantController@index',$sport->id) }}" class="btn btn-info">Participants</a></td> 
			</tr>
@endforeach
		</tbody>
	</table>
@endif
</div>
@stop