@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<!--  Affiche le nom d'un code comme titre -->
		<h2 class="panel-title">{{ $code->nom }}</h2>
	</div>
	<div class="panel-body">
		<!--  Affiche l'abréviation d'un code -->
		<p>Abréviation: <?php echo $code->abreviation ?></p>
		<!--  Affiche la description d'un code -->
		<p>Description: <?php echo $code->description ?></p>
		<a href="{{ URL::previous() }}" class="btn btn-primary">Retour</a>
	</div>
</div>
@stop