@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $epreuve->nom }}</h2>
	</div>
	<div class="panel-body">
		<p>Description: <?php if ($epreuve->description == "") {echo "Aucune description";} else {echo $epreuve->description;} ?></p>
@if (count($arbitresEpreuves) > 0)
		<div class="col-sm-4">
			<div class="list-group" id="list2">
				<a class="list-group-item active"><span class="glyphicon glyphicon-user"></span>Arbitres attitrés</a>
	@foreach($arbitresEpreuves as $arbitreEpreuve)
				<a class="list-group-item">{{ $arbitreEpreuve->nom }}, {{ $arbitreEpreuve->prenom }}</a>
	@endforeach
	<?php //TODO: ajouter la liste des participants. ?>
			</div>
		</div>
@endif
@if ($terrainsEpreuve->isEmpty())
		<p>Aucun terrain n'est associé à cette épreuve.</p>
@else
		<p>Terrains: </p>
		<ul>
	@foreach ($terrainsEpreuve as $terrain)
			<li>{{ $terrain->nom }}</li>
	@endforeach
		</ul>
@endif
	</div>
</div>
@stop