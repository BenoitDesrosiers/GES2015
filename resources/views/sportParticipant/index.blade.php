@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Liste des participants</h2>						
	</div>
</div>
@if ($regions->isEmpty())
	<div class="panel-body">
		<p>Aucune région</p>
	</div>
@else
	<table class="table table-striped table-hover">
		<tbody>
@foreach($regions as $region)
		<tr>
			<td><p> {{ $region->nom }}</p></td>
			<tr>
			<?php $flag = 0 ?>
				@foreach($participants as $participant)
					@if($participant->region_id == $region->id)
					<?php $flag = 1 ?>
						<tr> </tr>
						<td><p> {{ $participant->nom }}, {{ $participant->prenom }}</p></td> 					
					@endif
				@endforeach		
					@if($flag == 0)
					<td><p>aucun participant pour cette région</p></td>
					@endif
			</tr>
		</tr>
@endforeach	
@endif
		<tr>
			<td><a href="{{ action('SportsController@index') }}" class="btn btn-info">Retour</a></td>
		</tr>
		</tbody>
	</table>
<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
</div>
@stop