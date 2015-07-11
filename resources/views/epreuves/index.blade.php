<!-- epreuves -->
@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des épreuves</h2>
		{!! Form::open(['action'=> ['EpreuvesController@create'], 'class' => 'form', 'method' => 'get']) !!}
			{!! Form::hidden('sportId', '1', array('id'=>'sportId')) !!}
			{!! Form::submit('Créer une épreuve', ['class' => 'btn btn-info'])!!}
		{!! Form::close() !!}<br/>
		<div id="liste-sports">
			<?php $sportsListe = [];
			foreach($sports as $sport) {
				$sportsListe[$sport->id] = $sport->nom;
			}?>
			{!! Form::select('sportsListe', $sportsListe, $sportId, array('id' => 'sportsListe')) !!}
		</div> <!-- liste-sports -->
	</div>
	<div id="liste-epreuves">
		<?php // cette div sera remplie par le code js ?>
	</div> <!-- liste-epreuves -->
</div>
<script>
	function afficheListeEpreuves() {
		$.ajax({
			type: 'POST',
			url: '{{URL::action('EpreuvesController@epreuvesPourSport') }}',
			data: {  _token : $('meta[name="csrf-token"]').attr('content'),
				     sportId : document.getElementById('sportsListe').value },
			timeout: 10000,
			success: function(data){
				document.getElementById('liste-epreuves').innerHTML=data;
				}
		});		
	}	

	function updateCreateButton() {
		document.getElementById('sportId').value=document.getElementById('sportsListe').value;
	}		
		
	$(document).ready(function() {
		afficheListeEpreuves();
		updateCreateButton();
	});

	$("#sportsListe").change(function(e) {
		afficheListeEpreuves();
		updateCreateButton();
		
	});
</script>
@stop