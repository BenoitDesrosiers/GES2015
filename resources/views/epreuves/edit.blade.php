@extends('layout')

@section('script')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

	<script type="text/javascript">

		$('.ajouter').click(function(){
			transfererDroite();
			changer_liste();
		});
		$('.retirer').click(function(){
			transfererGauche();
			changer_liste();
		});

	</script>
	<script src="{{ asset('js/tableScript.js') }}"></script>
@stop

@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'une épreuve</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> ['EpreuvesController@update', $epreuve->id], 'method' => 'PUT', 'class' => 'form']) !!}
		<div id="liste-sports">
			<?php $sportsListe = [];
			foreach($sports as $sport) {
				$sportsListe[$sport->id] = $sport->nom;
			}?>
			{!! Form::select('sportsListe', $sportsListe, $sportId, array('id' => 'sportsListe')) !!}
		</div> <!-- liste-sports -->
		<div class="form-group">
			{!! Form::label('nom', '*Nom:') !!}
			{!! Form::text('nom',$epreuve->nom, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			{!! Form::open() !!}
			{!! Form::label('genre', '*Genre:') !!}
			<br/>
			{!! Form::radio('genre', 'mixte', $epreuve->genre == "mixte") !!}
			{!! Form::label('mixte', 'Mixte') !!}
			<br/>
			{!! Form::radio('genre', 'masculin', $epreuve->genre == "masculin", ['class' => 'radio_click', 'id' => 'genreM']) !!}

			{!! Form::label('masculin', 'Masculin') !!}
			<br/>
			{!! Form::radio('genre', 'féminin', $epreuve->genre == "féminin", ['class' => 'radio_click', 'id' => 'genreF']) !!}
			{!! Form::label('féminin', 'Féminin') !!}
			<br/>
			{{ $errors->first('genre') }}
			<script type="text/javascript">

				// Cette fonction crée une alerte afin d'aviser l'usager d'un risque de suppression.
				function confirmationPopup(genre) {
					bootbox.alert({
						title: "Attention".fontsize(8),
						message: ('Il y a des participants de genre \'' + genre + '\' dans l\'épreuve.' +
									' Lors de la confirmation, ceux-ci seront supprimés.').fontsize(4),
						size: 'Large',
						backdrop: true,
						closeButton: false,
						onEscape: true
					});

				};

				if ('<?php if ($proportionGenre[0] > 0){
							echo true;
						}else{
							echo false;
						}?>') {
						document.getElementById('genreF').onclick = function () {
							confirmationPopup('masculin');
						};
				}

				if ('<?php if ($proportionGenre[1] > 0){
							echo true;
						}else{
							echo false;
						}?>'){

					document.getElementById('genreM').onclick = function() {
						confirmationPopup('féminin');
					};
				}

				if ('<?php if (($proportionGenre[0] > 0) && ($proportionGenre[1] > 0)){
							echo true;
						}else{
							echo false;
						}?>'){
					document.getElementById('genre')

				}
			</script>
		</div>
		<div class="form-group">
			{!! Form::label('description', 'Description courte:') !!} 
			{!! Form::text('description',$epreuve->description, ['class' => 'form-control']) !!}
			{{ $errors->first('description') }}				
		</div>
		<div class="form-group">
			<label>Arbitres: </label>
			<!-- Code original par "Dey-Dey" adapté pour le site -->
			<div class="container bootstrap snippet">
				<div class="row">
					<div class="col-sm-4 col-sm-offset-1">
						<div class="list-group" id="list1">
							<a class="list-group-item active"><span class="glyphicon glyphicon-user"></span>Arbitres Disponibles<input title="toggle all" type="checkbox" class="all pull-right"></a>
							@foreach($arbitres as $arbitre)
								<a name="{{ $arbitre->id }}" class="list-group-item">{{ $arbitre->nom }}, {{ $arbitre->prenom }}<input type="checkbox" class="pull-right"></a>
							@endforeach
						</div>
					</div>
					<div class="col-md-2 boutonTableEpreuve-center">
						<a title="Ajouter" class="btn btn-default center-block ajouter"><i class="glyphicon glyphicon-chevron-right"></i></a>
						<a title="Retirer" class="btn btn-default center-block retirer"><i class="glyphicon glyphicon-chevron-left"></i></a>
					</div>
					<div class="col-sm-4">
						<div class="list-group" id="list2">
							<a class="list-group-item active"><span class="glyphicon glyphicon-user"></span>Arbitres attitrés<input title="toggle all" type="checkbox" class="all pull-right"></a>
							@foreach($arbitresEpreuves as $arbitreEpreuve)
								<a name="{{ $arbitreEpreuve->id }}" class="list-group-item">{{ $arbitreEpreuve->nom }}, {{ $arbitreEpreuve->prenom }}<input type="checkbox" class="pull-right"></a>
							@endforeach
						</div>
						<div>
							<input type="hidden" name="arbitresUtilises" id="arbitresUtilises"></input>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('terrains', 'Terrains:') !!}
			<div class="row">
				@if ($epreuveTerrains->isEmpty())
					<p>Il n'y a pas de terrain disponible pour cette épreuve.</p>
				@else
					@foreach ($epreuveTerrains as $terrain)
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 button-group" data-toggle="buttons">
							<label class="btn btn-default btn-block {{ $terrain->active }}">
								<input name="terrain[{{ $terrain->id }}]" type="checkbox" {{ $terrain->checked }}> {{ $terrain->nom }}
							</label><br/>
						</div>
					@endforeach
				@endif
			</div>
		</div>
		<div class="form-group">
			{!! Form::button('Sauvegarder', ['name' => 'save', 'type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>

		</div>
		{!! Form::close() !!}

	</div>
</div>
@stop

@section('stylesheet')
	<link rel="stylesheet" href="{{ asset('/css/tableCSS.css') }}">
@stop