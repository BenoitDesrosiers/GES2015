@extends('layout')
@section('content')
<?php use App\Models\Region;//TODO: enlever le code qui accède directement à Région de la view, et passer les régions en paramètre, une fois fait, enlever cette ligne?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des participants</h2>
		<div class="row">
			<div class="col-md-6" id="bouton-créer">
				<a href="{{ action('ParticipantsController@create') }}" class="btn btn-info">Créer un participant</a>
			</div> <!-- bouton créer -->
				{!! Form::open(['action'=> array('ParticipantsController@recherche'), 'method' => 'POST', 'class' => 'form']) !!}
			<div class="col-md-2" id="liste-filtres">
				{!! Form::select('listeFiltres', $listeFiltres, $valeurFiltre, ['style' => 'width:100%;', 'id' => 'listeFiltres']) !!}
			</div> <!-- liste-filtres -->
    		<div class="col-md-2" id="recherche">
    			{!! Form::text('entreeRecherche', $valeurRecherche, ['style' => 'width:100%;', 'id' => 'entreeRecherche'])!!}
    		</div><!-- recherche -->
    		<div class="col-md-2" id="boutonRecherche">
    			{!! Form::button('Recherche', ['type' => 'submit','style' => 'width:100%;', 'class' => 'btn btn-info'])!!}
    		</div><!-- buttonRecherche -->
    		{!! Form::close() !!}
		</div>				

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
							link_to_action($routeActionName, $infosTri["nom"]["texteAffiche"], $infosTri["nom"]["trie"])
						!!}
					</th>
					<th class="hidden-xs">
						<!-- Création des liens pour trier la colonne Numéro -->
						{!! 
							link_to_action($routeActionName, $infosTri["numero"]["texteAffiche"], $infosTri["numero"]["trie"])
						!!}
					</th>
					<th class="hidden-sm hidden-xs ">
						<!-- Création des liens pour trier la colonne Région -->
						{!! 
							link_to_action($routeActionName, $infosTri["region_id"]["texteAffiche"], $infosTri["region_id"]["trie"])
						!!}
					</th>
					<th class="col-sm-1"></th>
					<th class="col-sm-1"></th>
				</tr>
			</thead>
			<tbody>
			@foreach($participants as $participant)
				<tr>
					<td><a href="{{ action('ParticipantsController@show', $participant->id) }}">{{ $participant->nom }}, {{ $participant->prenom }}</a></td>
					<td class="hidden-xs">{{ $participant->numero }}</td>
					<td class="hidden-sm hidden-xs"><span data-toggle="tooltip" data-placement="bottom" title="{{ Region::where('id', '=', $participant->region_id)->get()[0]->nom }}">{{ Region::where('id', '=', $participant->region_id)->get()[0]->nom_court }}</span></td>
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
				$('[data-toggle="tooltip"]').tooltip();
				
			})
		</script>
	@endif
	<script src="{{ asset('js/participants.js') }}"></script>
	<script type="text/javascript">
	/*
	 * La fonction changerValeurRecherche() est appeler lorsque la page est prête
	 */
	$(function() {
		var listeRecherches = <?php echo json_encode($listeRecherches) . ";\n";?>
		var valeurRecherche = <?php echo json_encode($valeurRecherche); ?>;
		changerEntreeRecherche(listeRecherches, valeurRecherche);
	});

	/*
	 *  La fonction changerValeurRecherche() est appeler lorsque le menu #listeFiltres
	 *  change.
	 */	
	$("#listeFiltres").change(function() {
		var listeRecherches = <?php echo json_encode($listeRecherches) . ";\n";?>
		var valeurRecherche = "";
		changerEntreeRecherche(listeRecherches, valeurRecherche);
	});

	
	</script>
</div>
@stop