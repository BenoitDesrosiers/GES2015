<!-- resultats -->
@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Tableau des résultats</h2>
		<div class="row">
			<div class="col-md-4" id="liste-sports">
				<?php $sportsListe = [];
				foreach($sports as $sport) {
					$sportsListe[$sport->id] = $sport->nom;
				}?>
				{!! Form::select('sportsListe', $sportsListe, $sportId, array('id' => 'sportsListe', 'style' => 'width:100%;margin-bottom:10px;')) !!}
			</div> <!-- liste-sports -->
			<div class="col-md-4" id="liste-epreuves">
			</div> <!-- liste-epreuves -->
			<div class="col-md-4" id="liste-evenements">
			</div> <!-- liste-evenements -->
		</div>
	</div>
	<div id="resultat">
		<?php // cette div sera remplie par le code js ?>
	</div> <!-- liste-epreuves -->
</div>
<script>
	function afficheListeEpreuves() {
		document.getElementById('liste-epreuves').innerHTML='';
		document.getElementById('liste-evenements').innerHTML='';
		document.getElementById('resultat').innerHTML='';
		$.ajax({
			type: 'POST',
			url: '{{URL::action('ResultatsController@epreuvesPourSport') }}',
			data: { _token : $('meta[name="csrf-token"]').attr('content'),
				    sportId : document.getElementById('sportsListe').value },
			timeout: 10000,
			success: function(data){
				document.getElementById('liste-epreuves').innerHTML=data;
				afficheListeEvenements();
				$("#epreuvesListe").change(function(e) {
					afficheListeEvenements();
				});
			}
		});		
	}	

	function afficheListeEvenements() {
		document.getElementById('liste-evenements').innerHTML='';
		document.getElementById('resultat').innerHTML='';
		$.ajax({
			type: 'POST',
			url: '{{URL::action('ResultatsController@evenementsPourEpreuve') }}',
			data: { _token : $('meta[name="csrf-token"]').attr('content'),
				    epreuveId : document.getElementById('epreuvesListe').value },
			timeout: 10000,
			success: function(data){
				document.getElementById('liste-evenements').innerHTML=data;
				afficheResultat();
				$("#evenementsListe").change(function(e) {
					afficheResultat();
				});
			}
		});		
	}	

	function afficheResultat() {
		document.getElementById('resultat').innerHTML='';
		$.ajax({
			type: 'POST',
			url: '{{URL::action('ResultatsController@resultatPourEvenement') }}',
			data: { _token : $('meta[name="csrf-token"]').attr('content'),
				    evenementId : document.getElementById('evenementsListe').value },
			timeout: 10000,
			success: function(data){
				document.getElementById('resultat').innerHTML=data;
			}
		});		
	}	
		
	$(document).ready(function() {
		afficheListeEpreuves();
	});

	$("#sportsListe").change(function(e) {
		afficheListeEpreuves();
	});

	$("#epreuvesListe").change(function(e) {
		afficheListeEvenements();
	});

	$("#evenementsListe").change(function(e) {
		afficheResultat();
	});
</script>
@stop