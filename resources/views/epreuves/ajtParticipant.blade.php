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
				
					@if(count($participants) == 0)
						<p>Aucun participant d inscrit ! RIP</p>
					@else
						
						<tr><th>&nbsp;</th><th>Nom</th><th>Région</th><th>Numéro</th></tr>
						@foreach ($participants as $participant)
							<?php $checked = ""; ?>
							<!--  //FIXME: se servir des fonctions de collections: $listeIds = $epreuveParticipants->pluck('id'); ....  if($listeIds->contains($participant->id))... --> 
							@foreach ($epreuveParticipants as $epreuvePart)
								@if ($epreuvePart->id == $participant->id)
									<?php $checked = "checked"; ?>
								@endif
							@endforeach

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
					@endif
				
			</div>
			
		<div class="form-group">
			{!! Form::submit('Appliquer', array('class' => 'btn btn-primary')) !!}
			<a href="{{ action('EpreuvesController@index') }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</tbody>
</table>
@stop