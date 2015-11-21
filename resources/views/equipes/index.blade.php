@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des équipes</h2>
	</div>
@if ($equipes->isEmpty())
	<div class="panel-body">
		<p>Aucune équipe</p>
	</div>
@else
	<table class="table table-hover table-condensed">
		<thead>
			<tr>
				<th class="col-sm-3">Équipe</th>
				<th>Membres</th>
				<th class="hidden-xs">Région</th>
				<th class="hidden-xs">Sport</th>
				<th class="col-sm-1"/>
			</tr>
		</thead>
		<tbody>
<!-- 		Afficher toutes les équipes, même les vides -->
			@foreach($equipes as $equipe)
				<tr>
					<td>
						<a href="{!! action('EquipesController@show', $equipe->id) !!}">
							{!! $equipe->nom !!}
						</a>
					</td>
					<td>{!! $equipe->nombreMembres() !!}</td>
					<td class="hidden-xs">{!! $equipe->region->nom !!}</td>
					<td class="hidden-xs">{!! $equipe->sports[1]->nom !!}</td>
					<td>
						<a href="{!! action('EquipesController@edit', $equipe->id) !!}" class="btn btn-info">Modifier</a>
					</td>
				</tr>
<!-- 			Afficher tous les membres de l'équipe	 -->
				@foreach($equipe->membres as $membre)
					<tr class="active">
						<td/>
						<td colspan="4">
							<a href="{!! action('ParticipantsController@show', $membre->id) !!}">
								{!! $membre->nom !!}, {!! $membre->prenom !!}
							</a>
						</td>
					</tr>
				@endforeach
			@endforeach
		</tbody>
	</table>
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
@endif
</div>
@stop