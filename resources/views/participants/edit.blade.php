@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'un participant</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('ParticipantsController@update', $participant->id), 'method' => 'PUT', 'class' => 'form']) !!}
		<div class="form-group">
			{!! Form::label('nom', 'Nom:') !!} 
			{!! Form::text('nom',$participant->nom, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			{!! Form::label('prenom', 'Prenom:') !!} 
			{!! Form::text('prenom',$participant->prenom, ['class' => 'form-control']) !!}
			{{ $errors->first('prenom') }}
		</div>
		<div class="form-group">
			{!! Form::label('numero', 'Numéro:') !!} 
			{!! Form::text('numero',$participant->numero, ['class' => 'form-control']) !!}
			{{ $errors->first('numero') }}
		</div>
		<?php
			$regionArray = array();
			for ($i=0; $i<count($regions); $i++) {
				$regionArray[$i+1] = $regions[$i]['nom'];
			}
		?>
		<div class="form-group">
			{!! Form::label('region_id', 'Région:') !!} <br/>
			{!! Form::select('region_id', $regionArray, $participant->region_id) !!}
			{{ $errors->first('region_id') }}
		</div>
		<div class="form-group">
			{!! Form::label('equipe', 'Équipe:') !!} 
			{!! Form::checkbox('equipe', $participant->equipe==true, $participant->equipe==true) !!}
			{{ $errors->first('equipe') }}
		</div>
		<div class="form-group">
			{!! Form::label('sports', 'Sports:') !!} 
			<div class="row">
				<?php
					foreach ($sports as $sport) {
						$checked = "";
						$active = "";
						foreach ($participantSports as $partSport) {
							if ($partSport->id == $sport->id) {
								$checked = " checked";
								$active = " active";
								continue;
							}
						}
				?>
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 button-group" data-toggle="buttons">
			        <label class="btn btn-default btn-block<?=$active?>">
			            <input name="sport[{{ $sport->id }}]" type="checkbox"<?=$checked?>> {{ $sport->nom }}
			        </label><br/>
			    </div>
				<?php
					}
				?>
			</div>
		</div>
		<div class="form-group">
			{!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop