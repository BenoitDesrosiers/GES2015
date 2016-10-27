@extends('layout')

@section('script')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
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

			{!! Form::hidden('old_genre', $test = $epreuve->genre) !!}

			{!! Form::radio('genre', 'mixte', $epreuve->genre == "mixte") !!}
			{!! Form::label('mixte', 'Mixte') !!}
			<br/>
			{!! Form::radio('genre', 'masculin', $epreuve->genre == "masculin", ['class' => 'radio_click']) !!}
			{!! Form::label('masculin', 'Masculin') !!}
			<br/>
			{!! Form::radio('genre', 'feminin', $epreuve->genre == "feminin", ['class' => 'radio_click']) !!}
			{!! Form::label('feminin', 'Feminin') !!}
			<br/>
			{{ $errors->first('genre') }}
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

			{!! Form::button('Sauvegarder', ['name' => 'save', 'type' => 'submit', 'class' => 'btn btn-primary', 'onclick' => 'confirmationPopup()']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
			<script>
				function confirmationPopup() {
					var r = confirm("Press a button! " + "");
					if (r != true) {
						old()
					}
					return r;
				}
			</script>
		</div>
		{!! Form::close() !!}

	</div>
</div>
@stop

@section('script')

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

@section('stylesheet')
	<link rel="stylesheet" href="{{ asset('/css/tableCSS.css') }}">
@stop