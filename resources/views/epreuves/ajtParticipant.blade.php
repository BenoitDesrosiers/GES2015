@extends('layout') 
@section('content')

	<script> /* <<<< devrait être dans un fichier de script et mis en commun avec equipes/index.blade */
		function collapse_tbody(a_tbody, a_sign){
			a_tbody.classList.toggle("hidden");
			a_tbody.classList.toggle("show-tbody");
			a_sign.classList.toggle("glyphicon-minus");
			a_sign.classList.toggle("glyphicon-plus");
		}
	</script>
									
									
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>ajouter participant {{$epreuve->nom}}</h2>
	</div>
	
<table class="table table-striped table-hover">
	
		{!! Form::open(array('action' => array('EpreuvesController@storeParticipants', $epreuve->id))) !!}
	
		<?php
			$current_region = "";
		?>
		@if(count($participants) == 0)
			<p>Aucun participant d'inscrit.</p>
		@else
			
			<thead>
				<tr>
					<th class="col-sm-3">&nbsp;</th>
					<th class="col-sm-3">Nom</th>
					<th class="col-sm-3">Région</th>
					<th class="col-sm-1">Numéro</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($participants as $participant)
				<?php $checked = ""; ?>
				<!--  //FIXME: se servir des fonctions de collections: $listeIds = $epreuveParticipants->pluck('id'); ....  if($listeIds->contains($participant->id))... --> 
				@foreach ($epreuveParticipants as $epreuvePart)
					@if ($epreuvePart->id == $participant->id)
						<?php $checked = "checked"; ?>
					@endif
				@endforeach
				
				@if ($current_region != $participant->region->nom)
						<?php $current_region = $participant->region->nom ?>
						</tbody>
						<tr id="expanderHead">
							
							<td colspan="4">
									<button id="expanderSign{{$current_region}}" class="btn btn-default btn-mini glyphicon glyphicon-plus" type="button" onclick="collapse_tbody(document.getElementById('expanderContent{{$current_region}}'), document.getElementById('expanderSign{{$current_region}}'))"></button>
								{{$current_region}}
							</td>
						</tr>
						<tbody class="hidden" id="expanderContent{{$current_region}}">
				@endif
					<tr>
						<td>
							<input type="checkbox" name="participants[{{$participant->id}}]" {{$checked}}>
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
			@endforeach
			</tbody>
		@endif

			
		<div class="form-group">
			{!! Form::submit('Appliquer', array('class' => 'btn btn-primary')) !!}
				<a href="{{ action('EpreuvesController@index') }}" class="btn btn-danger">Annuler</a>
			{!! Form::close() !!}
		</div>
	</tbody>
</table>

</div>
@stop