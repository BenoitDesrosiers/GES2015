@extends('layout')
@section('content')
	{!! Form::open(array('action' => array('EvenementParticipantController@index', $evenement->id))) !!}
	<div class="panel panel-default">
		<input name="evenement" type="hidden" value="{!! $evenement->id !!}">
		<div class="panel-heading">
			<h2>Liste des participants pour {{ strtolower($evenement->nom) }}</h2>
		</div>

		<div class="panel-body">
			@if ($participants->isEmpty())
				<p>Il n'y a aucun participant lié à l'épreuve de l'événement choisi.</p>
			@else
				@foreach (['danger', 'warning', 'success', 'info'] as $msg)
					@if(Session::has('alert-' . $msg))
						<span class="text-{!! $msg !!}">{!! Session::get('alert-' . $msg) !!}</span>
					@endif
				@endforeach
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<!-- Titre des colonnes du tableau (s'adapte aux différentes dimensions selon les types de Bootstrap) -->
							<th>Nom, Prénom</th>
							<th class="hidden-xs">Région</th>
							<th>Participe</th>
						</tr>
					</thead>
					<tbody>
						@foreach($participants as $participant)
							<!-- Ajout de chaque participant de la base de données dans la table des participants -->
							<tr>
								<td>
									{{$participant->nom}}, {{$participant->prenom}}
								</td>
								<td class="hidden-xs">
									{{$participant->region->nom}}
								</td>
								<td>
									@if ($evenement->participants->contains($participant->id))
										<input name="participation[{{$participant->id}}]" title="Le participe participe à cet événement" type="checkbox" checked>
									@else
										<input name="participation[{{$participant->id}}]" title="Le participe participe à cet événement" type="checkbox">
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>

		<div class="panel-footer">
			@if (!($participants->isEmpty()))
				{!! Form::button('Sauvegarder', array('action' => 'EvenementParticipantController@store', 'class' => 'btn btn-primary', 'type' => 'submit')) !!}
			@endif
			<a href="{!! action('EvenementsController@index') !!}" class="btn btn-danger">Retour</a>
		</div>
	</div>
	{!! Form::close() !!}

@stop