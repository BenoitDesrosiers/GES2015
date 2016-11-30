@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des délégués</h2>
		<a href="{{ action('DeleguesController@create') }}" class="btn btn-info">Créer un délégué</a>
	</div>
	@if ($delegues->isEmpty())
		<div class="panel-body">
			<p>Aucun délégué</p>
		</div>
	@else
		@if ($regions->isEmpty())
			<p>Il n'existe aucune région dans le système.</p>
		@else
			<?php $regionListe = ["Toutes les régions"]?>
			@foreach($regions as $region)
				<?php $regionListe[$region->id] = $region->nom; ?>
			@endforeach
			<div>
				{!! Form::select('region_id', $regionListe, null, ['id' => 'region']) !!}
				{{ $errors->first('region_id') }}
			</div>
		@endif
			<div id="listeDelegues">

			</div>
	@endif
</div>

<script src="{!! asset('/js/delegue_index.js') !!}"></script>

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