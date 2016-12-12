@extends('layout') 
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>ajouter bénévole {{$epreuve->nom}}</h2>
	</div>
	
<table class="table table-striped table-hover">
	<tbody>
		
		{!! Form::open(array('action' => array('EpreuvesController@storeBenevoles', $epreuve->id))) !!}
	
			<div>
				<?php  //TODO: séparer les benevoles par régions, ou encore mieux, avoir un filtre de région
					foreach ($benevoles as $benevole) {
						$checked = "";
						//FIXME: se servir des fonctions de collections: $listeIds = $epreuveBenevoles->pluck('id'); ....  if($listeIds->contains($benevole->id))... 
						foreach ($epreuveBenevoles as $epreuvePart) {
							if ($epreuvePart->id == $benevole->id) {
								$checked = " checked";
								continue;
							}
						}
				?>
				<div>			  
			            <input type="checkbox" name="benevoles[{{$benevole->id}}]" <?=$checked?>> {{$benevole->nom}}, {{$benevole->prenom}} <br/>
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
	</tbody>
</table>
@stop