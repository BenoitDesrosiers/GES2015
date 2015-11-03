@extends('layout')
@section('content')
<?php use App\Models\Region;//TODO: enlever le code qui accède directement à Région de la view, et passer les régions en paramètre, une fois fait, enlever cette ligne?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des participants</h2>
		<div class="row">
			<div class="col-md-7" id="bouton-créer">
				<a href="{{ action('ParticipantsController@create') }}" class="btn btn-info">Créer un participant</a>
			</div> <!-- bouton créer -->
			{!! Form::open(['action'=> array('ParticipantsController@recherche'), 'method' => 'POST', 'class' => 'form']) !!}
			<div class="col-md-2" id="liste-filtres">
				{!! Form::select('listeFiltres', $listeFiltres, $valeurFiltre, ['style' => 'width:100%; height:25px;', 'id' => 'listeFiltres']) !!}
			</div> <!-- liste-filtres -->
    		<div class="col-md-2" id="recherche">
    			{!! Form::text('champRecherche', $valeurRecherche, ['style' => 'width:100%; height:25px;', 'id' => 'champRecherche'])!!}
    		</div><!-- recherche -->
    		<div class="col-md-1" id="boutonRecherche">
    			{!! Form::button('Recherche', ['type' => 'submit','style' => 'width:100%; height:25px;'])!!}
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
					<th class="hidden-sm hidden-xs">
						<!-- Création des liens pour trier la colonne Région -->
						{!! 
							link_to_action($routeActionName, $infosTri["region_id"]["texteAffiche"], $infosTri["region_id"]["trie"])
						!!}
					</th>
					<th class="hidden-sm hidden-xs">
						<!-- Création des liens pour trier la colonne Équipe -->
						{!!
							link_to_action($routeActionName, $infosTri["equipe"]["texteAffiche"], $infosTri["equipe"]["trie"])
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
				$('[data-toggle="tooltip"]').tooltip();
			})
		</script>
	@endif
	<script>
		$(function() {
			changerValeurRecherche();
		});
	
		$("#listeFiltres").change(function(event) {
			changerValeurRecherche();
		});
		
		function changerValeurRecherche() {
			var valeurFiltre = $("option:selected", "#listeFiltres").val();
			
			if (!(valeurFiltre == 3 || valeurFiltre == 4)) {
				
				var champTexte = $("<input id='champRecherche' type='text' name='champRecherche' style='width:100%; height:25px;'/>");
		
				$("#champRecherche").remove();
			    $("#recherche").prepend(champTexte);
			    
			} else if (valeurFiltre == 3) {
				
				var selecteur = $("<select id='champRecherche' name='champRecherche' style='width:100%; height:25px;'/>");
				var donnee = getListeRegion();
				var valeurRecherche = "<?php echo($valeurRecherche); ?>";
				if (valeurRecherche == "") {
					valeurRecherche = "abt";
				}
				
				for(var valeur in donnee) {
				    $("<option />", {value: valeur, text: donnee[valeur]}).appendTo(selecteur);
				}
				
				selecteur.val(valeurRecherche);
				$("#champRecherche").remove();
			    $("#recherche").prepend(selecteur);
			    
			} else if (valeurFiltre == 4) {
				
				var selecteur = $("<select id='champRecherche' name='champRecherche' style='width:100%; height:25px;'/>");
				var donnee = getChoixEquipe();
				var valeurRecherche = "<?php echo($valeurRecherche); ?>";
				if (valeurRecherche == "") {
					valeurRecherche = "non";
				}
				
				for(var valeur in donnee) {
				    $("<option />", {value: valeur, text: donnee[valeur]}).appendTo(selecteur);
				}
				
				selecteur.val(valeurRecherche);
				$("#champRecherche").remove();
			    $("#recherche").prepend(selecteur);
			    
			}
		}

		function getChoixEquipe() {
			var donnee = {
					"non":"Non",
					"oui":"Oui"
					};
			return donnee;
		}
		
		function getListeRegion() {
			var donnee = {
					"abt":"ABT",
					"bou":"BOU",
					"cap":"CAP",
					"cdq":"CDQ",
					"cha":"CHA",
					"ctn":"CTN",
					"edq":"EDQ",
					"lsl":"LSL",
					"lan":"LAN",
					"lau":"LAU",
					"lav":"LAV",
					"mau":"MAU",
					"mon":"MON",
					"out":"OUT",
					"riy":"RIY",
					"ris":"RIS",
					"slj":"SLJ",
					"suo":"SUO"
					};
			return donnee;
		}
	
	</script>
</div>
@stop