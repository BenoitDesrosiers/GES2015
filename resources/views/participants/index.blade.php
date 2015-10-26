@extends('layout')
@section('content')
<?php use App\Models\Region; //TODO: enlever le code qui accède directement à Région de la view, et passer les régions en paramètre, une fois fait, enlever cette ligne?>
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
				<th>
					<!-- Création des liens pour trier la colonne Nom -->
					{!! 
						link_to_action(
							$colonnesTriees["colNom"]["contrl"],
							$colonnesTriees["colNom"]["texteAffiche"],
							$colonnesTriees["colNom"]["trie"]
						)
					!!}
				</th>
				<th class="hidden-xs">
					<!-- Création des liens pour trier la colonne Numéro -->
					{!! 
						link_to_action(
							$colonnesTriees["colNum"]["contrl"],
							$colonnesTriees["colNum"]["texteAffiche"],
							$colonnesTriees["colNum"]["trie"]
						)
					!!}
				</th>
				<th class="hidden-sm hidden-xs">
					<!-- Création des liens pour trier la colonne Région -->
					{!! 
						link_to_action(
							$colonnesTriees["colRegion"]["contrl"],
							$colonnesTriees["colRegion"]["texteAffiche"],
							$colonnesTriees["colRegion"]["trie"]
						)
					!!}
				</th>
				<th class="hidden-sm hidden-xs">
					<!-- Création des liens pour trier la colonne Équipe -->
					{!!
						link_to_action(
							$colonnesTriees["colEquipe"]["contrl"],
							$colonnesTriees["colEquipe"]["texteAffiche"],
							$colonnesTriees["colEquipe"]["trie"]
						)
					!!}
				</th>
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