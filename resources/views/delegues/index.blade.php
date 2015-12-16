@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des délégués</h2>
		<a href="{{ action('DeleguesController@create') }}" class="btn btn-info">Créer un délégué</a>
	</div>
	@if ($delegues->isEmpty())
		<div class="panel-body">
			<p>Aucun rôle</p>
		</div>
	@else
		<table class="table table-condensed table-hover">
			<thead>
				<tr>
					<th>Nom</th>
					<th class="hidden-xs">Région</th>
					<th class="hidden-xs">Rôle</th>
					<th class="hidden-xs">Accréditation</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($delegues as $delegue)
					<tr class="rangeeEquipe">
						<td><a href="{{ action('DeleguesController@show', $delegue->id) }}">{{ $delegue->nom }}, {{ $delegue->prenom }}</a></td>
						<td class="hidden-sm hidden-xs"><span data-toggle="tooltip" data-placement="bottom" title=<?php echo $delegue->region->nom ?>><?php echo $delegue->region->nom_court ?></span></td>
						<td>
							@if ($delegue->nombreRoles() >= 2)
								<button type="submit" class="btn btn-default btn-mini glyphicon glyphicon-plus" onClick="afficherRoles(this)"/>
							@elseif ($delegue->nombreRoles() == 1)
								@foreach($delegue->roles as $role)
									<a href="{!! action('RolesController@show', $role->id) !!}">
										{!! $role->nom !!}
									</a>
								@endforeach
							@endif
						</td>
						<td class="hidden-sm hidden-xs"><?php if($delegue->accreditation) echo "Oui"; else echo "Non"; ?></td>
						<td><a href="{{ action('DeleguesController@edit',$delegue->id) }}" class="btn btn-info">Modifier</a></td>
						<td>{!! Form::open(array('action' => array('DeleguesController@destroy',$delegue->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
							<button type="submit" href="{{ URL::route('delegues.destroy', $delegue->id) }}" class="btn btn-danger btn-mini">Effacer</button>
							{!! Form::close() !!}   {{-- méthode pour faire le delete tel que décrit sur http://www.codeforest.net/laravel-4-tutorial-part-2 , 
													un script js est appelé pour tous les form qui ont un "data-confirm" (voir assets/js/script.js) --}}
						</td>
						<!--	Afficher tous les rôles du délégué	 -->
						@if(!$delegue->roles->isEmpty())
							<tr class="active rangeeMembres">
								<td/>
								<td/>
								<td colspan="5">
									<ul>
										@foreach($delegue->roles as $role)
											<li>
												<a href="{!! action('RolesController@show', $role->id) !!}">
													{!! $role->nom !!}
												</a>
											</li>
										@endforeach
									</ul>
								</td>
							</tr>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
</div>

<script>
	// 	Affiche ou masque les rôles d'un délégué donné
	function afficherRoles(bouton) {
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

<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>

<style>
	/* Masquer les rôles par défaut */
	.rangeeEquipe + .rangeeMembres {
		display: none;
	}
	/* Les rôle sont visibles quand la rangée délégué a la classe .actif	 */
	.rangeeEquipe.actif + .rangeeMembres {
		display: table-row;
	}
	.rangeeMembres ul {
		list-style: none;
		padding: 0;
	}
</style>

@stop