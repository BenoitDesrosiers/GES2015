@extends('layout') 
@section('content')

	<script>
		function collapse_tbody(a_tbody, a_sign){
			if(a_tbody.style.display=='none'){
				a_tbody.style.display='table-row-group';
				a_sign.classList.remove("glyphicon-plus");
				a_sign.classList.add("glyphicon-minus");
			}else{
				a_tbody.style.display='none';
				a_sign.classList.remove("glyphicon-minus");
				a_sign.classList.add("glyphicon-plus");
			}
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
					<th style="width: 5%;">&nbsp;</th>
					<th style="width: 45%">Nom</th>
					<th style="width: 45%">Région</th>
					<th style="width: 5%">Numéro</th>
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
						<tr style="CURSOR: pointer" id="expanderHead">
							
							<td colspan="4">
									<button id="expanderSign{{$current_region}}" class="btn btn-default btn-mini glyphicon glyphicon-plus" type="button" onclick="collapse_tbody(document.getElementById('expanderContent{{$current_region}}'), document.getElementById('expanderSign{{$current_region}}'))"></button>
								{{$current_region}}
							</td>
						</tr>
						<tbody style="display:none;" id="expanderContent{{$current_region}}">
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