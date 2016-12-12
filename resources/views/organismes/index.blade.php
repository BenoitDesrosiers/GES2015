@extends('layout')
@section('content')
	<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des organismes</h2>
		<a href="{{ action('OrganismesController@create') }}" class="btn btn-info">Créer un organisme</a>
	</div>

	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th/>
				<th class="col-sm-3">Nom de l'organisme</th>
				<th># de téléphone</th>
				<th>Description</th>
				<th class="col-xs-1 col-sm-1"/>
				<th class="col-xs-1 col-sm-1"/>
			</tr>
		</thead>
		@foreach($organismes as $organisme)
			<tr class="rangeeOrganisme" >
				<td>
					@if (!$organisme->contacts->isEmpty())
						<button type="submit" class="btn btn-default btn-mini glyphicon glyphicon-plus" onClick="afficherContacts(this)"/>
					@endif
				</td>
				<td>
					<a href="{!! action('OrganismesController@show', $organisme->id) !!}">
							{{ $organisme->nomOrganisme }}
					</a>
				</td>
				<td>
					@if ($organisme->telephone === NULL || $organisme->telephone === "")
						<p>Aucun</p>
					@else
						{{ $organisme->telephone }}
					@endif
				</td>
				<td>
					@if ($organisme->description === NULL || $organisme->description === "")
						<p>Aucune description</p>
					@else
						{{ $organisme->description }}
					@endif
				</td>
				<td>
					<a href="{!! action('OrganismesController@edit', $organisme->id) !!}" class="btn btn-info">Modifier</a>
				</td>
				<td>
					{{ Form::open(array('action' => array('OrganismesController@destroy', $organisme->id), 'method' => 'delete', 'data-confirm' => 'Voulez-vous vraiment supprimer cet organisme ainsi que tous ses contacts?')) }}
						<button type="submit" class="btn btn-danger btn-mini">Supprimer</button>
					{{ Form::close() }}
				</td>
			</tr>

			@if(!$organisme->contacts->isEmpty())
					<tr class="active rangeeContact">
						<td/>
						<td/>
						<td colspan="5">
							<ul>
								@foreach($organisme->contacts as $contact)
									<li>
										<a href="{!! action('OrganismesController@show', $organisme->id) !!}">
											{!! $contact->nom !!}, {!! $contact->prenom !!}
										</a>
									</li>
								@endforeach
							</ul>
						</td>
					</tr>
				@endif
		@endforeach
	</table>
@stop

<script>
// 	Affiche ou masque les contacts des organismes.
	function afficherContacts(bouton) {
		rangee = bouton.parentNode.parentNode;
		if (rangee.classList.contains("actif")) {
			bouton.classList.remove("glyphicon-minus");
			bouton.classList.add("glyphicon-plus");
			rangee.classList.remove("actif");
		} else {
			bouton.classList.remove("glyphicon-plus");
			bouton.classList.add("glyphicon-minus");
			rangee.classList.add("actif");
		}
	}
</script>

<style>
	/* Masquer les membres par défaut */
	.rangeeOrganisme + .rangeeContact {
		display: none;
	}
	/* Les membres sont visibles quand la rangée organisme a la classe .actif	 */
	.rangeeOrganisme.actif + .rangeeContact {
		display: table-row;
	}
	.rangeeContact ul {
		list-style: none;
		padding: 0;
	}
</style>