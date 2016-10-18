@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Ajouter un participant : {{$epreuve->nom}}</h2>
	</div>
	
<table class="table table-striped table-hover">
	<tbody>

		{!! Form::open(array('action' => array('EpreuvesController@storeParticipants', $epreuve->id))) !!}
		{!! Form::open(array('action' => array('EpreuvesController@ajtParticipants', $regions->id))) !!}

			<!--    Méthode comme délégué create    -->
			<?php
			$regionArray = array();
			for ($i=0; $i<count($regions); $i++) {
				$regionArray[$regions[$i]['id']]  = $regions[$i]['nom'];
			}
			?>
			<div class="form-group">
				{!! Form::label('region_id', 'Région:') !!} <br/>
				{!! Form::select('region_id', $regionArray) !!}
				{{ $errors->first('region_id') }}
			</div>
			<div>
				<?php  //TODO: séparer les participants par régions, ou encore mieux, avoir un filtre de région
					foreach ($participants as $participant) {
						$checked = "";
						//FIXME: se servir des fonctions de collections: $listeIds = $epreuveParticipants->pluck('id'); ....  if($listeIds->contains($participant->id))... 
						foreach ($epreuveParticipants as $epreuvePart) {
							if ($epreuvePart->id == $participant->id) {
								$checked = " checked";
								continue;
							}
						}
				?>
				<div>			  
			            <input type="checkbox" name="participants[{{$participant->id}}]" <?=$checked?>> {{$participant->nom}}, {{$participant->prenom}} <br/>
			    </div>
				<?php
					}
				?>
			</div>
			
		<div class="form-group">
			{!! Form::submit('Appliquer', array('class' => 'btn btn-primary')) !!}
			<a href="{{ action('EpreuvesController@index') }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
		{!! Form::close() !!}
	</tbody>
</table>
<script>
	function afficherListeRegions() {
		$.ajax({

		});
	}
</script>
@stop