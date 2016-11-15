<!-- 
	author: Francis M
	version: 0.0.1
	
	Code pour afficher les arbitres lorsque l'utilisateur clique sur le bouton
	"Arbitre" dans l'onglet "Sports".

 -->

@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $sport->nom }}</h2>
	</div>
	<div class="panel-body">
		<p>Description: <?php if ($sport->description == "") {echo "Il n'y a aucune description";} else {echo $sport->description;} ?></p>
@if (count($arbitresSports) > 0)
		<div class="col-sm-4">
			<div class="list-group" id="list2">
				<a class="list-group-item active"><span class="glyphicon glyphicon-user"></span>Arbitres attitrés</a>
	@foreach($arbitresSports as $arbitreSport)
				<a class="list-group-item">{{ $arbitreSport->nom }}, {{ $arbitreSport->prenom }}</a>
	@endforeach
			</div>
		</div>
@endif
	</div>
	<a href="{{ URL::previous() }}" class="btn btn-danger">Retour</a>
</div>
@stop