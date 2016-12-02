@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<!--  Affiche le nom d'une association comme titre -->
		<h2 class="panel-title">{{ $association->nom }}</h2>
	</div>
	<div class="panel-body">
		<!--  Affiche l'abréviation d'une association -->
		<p>Abréviation: <?php echo $association->abreviation ?></p>
		<!--  Affiche la description d'une association -->
		<p>Description: <?php echo $association->description ?></p>
		<a href="{{ URL::previous() }}" class="btn btn-primary">Retour</a>
	</div>
</div>
@stop