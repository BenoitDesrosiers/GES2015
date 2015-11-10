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
			<td colspan="3"><p> {{ $region->nom }}</p></td>
		</tr>
			<?php $flag = 0 ?>
				@foreach($participants as $participant)
					@if($participant->region_id == $region->id)
						<?php $flag = 1 ?>
						<tr> 
							<td class="col-xs-1"> </td>
							<td>
								<p>{{ $participant->nom }}, {{ $participant->prenom }}</p> 
							</td>
						</tr>
					@endif
				@endforeach		
					@if($flag == 0)
						<tr>
							<td  colspan="2"><p>aucun participant pour cette région</p></td>
						</tr>
					@endif
@endforeach	
@endif
		<tr>
			<td><a href="{{ URL::previous() }}" class="btn btn-danger">Retour</a></td>
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