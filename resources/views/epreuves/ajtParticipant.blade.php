@extends('layout') 
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>ajouter participant {{$epreuve->nom}}</h2>
	</div>
	
<table class="table table-striped table-hover">
	<tbody>
		
		{!! Form::open(array('action' => array('EpreuvesController@storeParticipants', $epreuve->id))) !!}
	
			<div>
				<?php  //TODO: séparer les participants par régions, ou encore mieux, avoir un filtre de région
					echo ("<tr><th>&nbsp;</th><th>Nom</th><th>Région</th><th>Numéro</th></tr>");
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
				<tr>
					<td>
			            <input type="checkbox" name="participants[{{$participant->id}}]" <?=$checked?>>
					</td>
					<td>
						{{$participant->nom}}, {{$participant->prenom}}
					</td>
					<td>
						{{$participant->region->nom}}
					</td>
					<td>
						{{$participant->numero}}
					</td>
			    </tr>
				<?php
					}
				?>
			</div>
			
		<div class="form-group">
			{!! Form::submit('Appliquer', array('class' => 'btn btn-primary')) !!}
			<a href="{{ action('EpreuvesController@index') }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</tbody>
</table>
@stop