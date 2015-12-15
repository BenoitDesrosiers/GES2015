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
				<?php
					foreach ($participants as $participant) {
						$checked = "";
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
	</tbody>
</table>
@stop