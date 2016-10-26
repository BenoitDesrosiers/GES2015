@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Création d'une épreuve</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> ['EpreuvesController@index'], 'class' => 'form']) !!}
		<div id="liste-sports">
			<?php $sportsListe = [];
			foreach($sports as $sport) {
				$sportsListe[$sport->id] = $sport->nom;
			}?>
			{!! Form::select('sportsListe', $sportsListe, $sportId, array('id' => 'sportsListe')) !!}
		</div> <!-- liste-sports -->
		<div class="form-group">
			{!! Form::label('nom', '*Nom:') !!}
			{!! Form::text('nom',null, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			{!! Form::label('genre', '*Genre:') !!}
			<br/>
			{!! Form::radio('genre', 'mixte', true) !!}
			{!! Form::label('mixte', 'Mixte') !!}
			<br/>
			{!! Form::radio('genre', 'masculin') !!}
			{!! Form::label('masculin', 'Masculin') !!}
			<br/>
			{!! Form::radio('genre', 'feminin') !!}
			{!! Form::label('feminin', 'Feminin') !!}
			<br/>
			{{ $errors->first('genre') }}
		</div>
		<div class="form-group">
			{!! Form::label('description', 'Description courte:') !!} 
			{!! Form::text('description',null, ['class' => 'form-control']) !!}
			{{ $errors->first('description') }}				
		</div>
		<div class="form-group">
			<!-- Code original par "Dey-Dey" adapté pour le site --> <?php //TODO: mettre ca dans un include car c'est commun a create et edit ?>
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
		          </div>
		          <div>
					<input type="hidden" name="arbitresUtilises" id="arbitresUtilises"></input>
		          </div>
		        </div>
			  </div>
			</div>
		</div>
		<div class="form-group">
			{!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
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