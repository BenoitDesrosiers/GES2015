@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">		
		<h3>Titre de l'événement:</h3>
		<h2><?php echo $evenement->nomEvenement ?></h2>
		<a href="{{ action('SystemeController@edit',$evenement->id) }}" class="btn btn-info">modifier</a>						
	</div>
</div>
@stop