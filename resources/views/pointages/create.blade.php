@extends('layout')
@section('content')
{!! Form::open(['action'=> 'PointagesController@store', 'class' => 'form']) !!}
<div class="panel panel-default">
	<div id="panel-heading" class="panel-heading">
		<h2>Créer une table de pointages</h2>
		<div class="row">
			<div class="col-md-3" >
				{!! Form::select('listeSports', $listeSports, '', ['id'=>'listeSports', 'class'=>'form-control']) !!}
			</div>
			<div class="form-inline">
				<div class="form-group" >
					{!! Form::label('valeurInitiale', 'Valeur initiale:') !!}
					{!! Form::text('valeurInitiale', '', ['id' => 'valeurInitiale', 'class'=>'form-control']) !!}
				</div>
				<div class="form-group" >
					{!! Form::label('decrement', 'Décrément:') !!}
					{!! Form::text('decrement', '', ['id' => 'decrement', 'class'=>'form-control']) !!}
				</div>
				<div class="form-group" >
					{!! Form::button('Générer', ['onClick' => 'genererTablePointages()', 'class' => 'btn btn-info'])!!}
					{!! Form::button('Vider', ['onClick' => 'viderTablePointages()', 'class' => 'btn btn-danger'])!!}
				</div>
			</div>
		</div>

	</div><!-- pannel-heading -->
	<div id="divTable" class="panel-body">
			<p id="tableVide" >Aucune table de pointage</p>
			<table id="tablePointages" class="table table-striped table-hover col-md-12 hide">
			<thead class="col-md-12" style="display: block;">
				<tr class="row col-md-12">
					<th class="col-md-12">Position</th>
					<th class="col-md-12">Valeur</th>
				</tr>
			</thead>
			<tbody class="col-md-12" style="height: 500px; overflow-y: auto; display: block; ">
				<!-- JavaScript -->
			</tbody>
			<tfoot style="display: block;">
				<tr>
					<td>
						<a class='btn btn-default glyphicon glyphicon-plus' id='btnAjouterRangee' onClick='ajouterRangee()'></a>
						<a class='btn btn-default glyphicon glyphicon-minus' id='btnRetirerRangee' onClick='retirerRangee()'></a>
						<button class='btn btn-info' id='btnConfirmer' type='submit'>Confirmer</button>
					</td>
				</tr>
			</tfoot>
		</table>
	</div><!-- divTable -->

	<script src="{{ asset('js/pointages.js') }}"></script>
	<script type="text/javascript">
		$(function() {
			vierge = true;
			afficherTablePointages();
		});
		
		$("#listeSports").on("focus", function() {
			var valeurPrecedente = this.value;
		}).change(function() {
			if (!vierge) {
				var choix = confirm("Vos changement seront supprimé. Voulez vous continuer?");
				if( choix == true ){
					$("#tablePointages").children("tbody").empty();
					afficherTablePointages();
				} else {
					this.value = valeurPrecedente
				}
			} else {
				$("#tablePointages").children("tbody").empty();
				afficherTablePointages();
			}
			valeurPrecedente = this.value;
		});

		function afficherTablePointages() {
			$.ajax({
				type: 'POST',
				url: '{{ URL::action('PointagesController@pointagesPourSport') }}',
				data: {  _token : $('meta[name="csrf-token"]').attr('content'),
					     sportId : document.getElementById('listeSports').value},
				timeout: 10000,
				success: function(data){
					if (data.length > 0){
						for (var cle in data){
							ajouterValeur(data[cle]['valeur']);
						}
						$("#tableVide").addClass("hide");
						$("#tablePointages").removeClass("hide");
						vierge = true;
					} else {
						$("#tableVide").removeClass("hide");
						$("#tablePointages").addClass("hide");
					}
				}
			});	
		}

		$("#divTable").change(function() {
			vierge = false;
		});
	</script>
</div>   
{!! Form::close() !!}
@stop