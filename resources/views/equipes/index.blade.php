@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des équipes</h2>
		<a href="{{ action('EquipesController@create') }}" class="btn btn-info">Créer une équipe</a>
	</div>
@if ($equipes->isEmpty())
	<div class="panel-body">
		<p>Aucune équipe</p>
	</div>
@else
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th class="col-sm-3">Équipe</th>
				<th>Membres</th>
				<th class="hidden-xs">Région</th>
				<th class="hidden-xs">Sport</th>
				<th class="col-sm-1"/>
				<th class="col-sm-1"/>
			</tr>
		</thead>
		<tbody>
<!-- 		Afficher toutes les équipes, même les vides -->
			@foreach($equipes as $equipe)
<!-- 			Les équipes vides ont une apparence légèrement différente	 -->
				<tr class="rangeeEquipe @if ($equipe->nombreMembres() == 0) active @endif" onClick="afficherMembres(this)" >
					<td>
						<a href="{!! action('EquipesController@show', $equipe->id) !!}">
							{!! $equipe->nom !!}
						</a>
					</td>
					<td>{!! $equipe->nombreMembres() !!}</td>
					<td class="hidden-xs">{!! $equipe->region->nom !!}</td>
					<td class="hidden-xs">@if ($equipe->sport()) {!! $equipe->sport()->nom !!} @endif </td>
					<td>
						<a href="{!! action('EquipesController@edit', $equipe->id) !!}" class="btn btn-info">Modifier</a>
					</td>
					<td>
						{!! Form::open(array('action' => array('EquipesController@destroy',$equipe->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
						<button type="submit" href="{{ URL::route('equipes.destroy', $equipe->id) }}" class="btn btn-danger btn-mini">Effacer</button>
						{!! Form::close() !!}
					</td>
				</tr>
<!-- 			Afficher tous les membres de l'équipe	 -->
				@if(!$equipe->membres->isEmpty())
					<tr class="info rangeeMembres">
						<td/>
						<td colspan="5">
							<ul>
								@foreach($equipe->membres as $membre)
									<li>
										<a href="{!! action('ParticipantsController@show', $membre->id) !!}">
											{!! $membre->nom !!}, {!! $membre->prenom !!}
										</a>
									</li>
								@endforeach
							</ul>
						</td>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
@endif
</div>

<script>
// 	Affiche ou masque les membres d'une équipe donnée
	function afficherMembres(equipe) {
		if (equipe.classList.contains("actif")) {
			equipe.classList.remove("actif");
		} else {
			equipe.classList.add("actif");
		}
	}
</script>

<style>
	/* Masquer les membres par défaut */
	.rangeeEquipe + .rangeeMembres {
		display: none;
	}
	/* Les membres sont visibles quand la rangée équipe a la classe .actif	 */
	.rangeeEquipe.actif + .rangeeMembres {
		display: table-row;
	}
	.rangeeMembres ul {
		list-style: none;
		padding: 0;
	}
</style>

@stop