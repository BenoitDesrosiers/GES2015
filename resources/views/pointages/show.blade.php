@extends('layout')
@section('content')


<div class="panel panel-default">
	<div class="panel-heading">
		<h2>{{$pointages->first()->sport->nom}}</h2>		
	</div>
	<div class="panel-body">
		@if (empty($pointages))
				<p>Aucune table de pointage</p>
			
		@else
			<table id="tablePointages", class="table table-striped table-hover col-md-12">
				<thead class="col-md-12" style="display: block;">
					<tr class="row col-md-12">
						<th class="col-md-12">Position</th>
						<th class="col-md-12">Valeur</th>
					</tr>
				</thead>
				<tbody class="col-md-12" style="max-height: 500px; overflow-y: auto; display: block; ">
				@foreach($pointages as $pointage)
					<tr class="col-md-12" style="height: 50px">
						<td class="col-md-12"><p>{{$pointage->position}}</p></td>
						<td class="col-md-12"><p>{{$pointage->valeur}}<p></td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@endif
	</div>
</div>
@stop