@extends('layout') 
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des participants {{$epreuve->nom}}</h2>
	</div>
</div>

<table class="table table-hover">
<?php $region_id = 0; ?>
@foreach($participants as $participant)
	@if($participant->region_id != $region_id)
		<tr  class="active"> 
			<td colspan="3">
				<p>{{ $participant->region->nom_court}}, {{ $participant->region->nom}}</p> 
			</td>
		</tr>
		<?php $region_id = $participant->region_id; ?>	
	@endif
	<tr> 
		<td class="col-xs-1"> </td>
		<td>
			<p>{{ $participant->nom }}, {{ $participant->prenom }}</p> 
		</td>
	</tr>
@endforeach
	<tr>
		<td><a href="{{ URL::previous() }}" class="btn btn-danger">Retour</a></td>
	</tr>
</table>
@stop