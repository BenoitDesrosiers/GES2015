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
			</div>
		</div>
@endif
	</div>
</div>
@stop