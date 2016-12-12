@extends('layout') 
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des bénévoles {{$epreuve->nom}}</h2>						
	</div>
</div>

<table class="table table-hover">
@foreach($benevoles as $benevole)
	<tr> 
		<td class="col-xs-1"> </td>
		<td>
			<p>{{ $benevole->nom }}, {{ $benevole->prenom }}</p> 
		</td>
	</tr>
@endforeach
	<tr>
		<td><a href="{{ URL::previous() }}" class="btn btn-danger">Retour</a></td>
	</tr>
</table>
@stop