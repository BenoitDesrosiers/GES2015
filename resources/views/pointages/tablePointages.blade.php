@if (count($pointages) < 1)
		<div class="panel-body">
			<p>Aucune table de pointage</p>
		</div>
@else
	<table id="tablePointages", class="table table-striped table-hover col-md-12">
		<thead class="col-md-12" style="display: block;">
			<tr class="row col-md-12">
				<th class="col-md-12">Position</th>
				<th class="col-md-12">Valeur</th>
			</tr>
		</thead>
		<tbody class="col-md-12" style="height: 500px; overflow-y: auto; display: block; ">
		@foreach($pointages as $pointage)
			<tr class="col-md-12" style="height: 50px">
				<td class="col-md-10"><p>{{$pointage["position"]}}</p></td>
				<td class="col-md-10"><input name="valeur[{{$pointage['position']}}]" type="text" class="form-control col-md-12" name="champValeur" value="{{$pointage['valeur']}}"/></td>
			</tr>
		@endforeach
		</tbody>
		<tfoot display: block;>
			<tr>
				<td>
					<a class='btn btn-default glyphicon glyphicon-plus' id='btnAjouterRangee' onClick='ajouterRangee()'></a>
					<a class='btn btn-default glyphicon glyphicon-minus' id='btnRetirerRangee' onClick='retirerRangee()'></a>
					<button class='btn btn-info' id='btnConfirmer' type='submit'>Confirmer</button>
				</td>
			</tr>
		</tfoot>
	</table>
@endif