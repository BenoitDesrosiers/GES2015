@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'un arbitre</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('ArbitresController@update', $arbitre->id), 'method' => 'PUT', 'class' => 'form']) !!}
		<div class="form-group">
			{!! Form::label('nom', 'Nom:') !!} 
			{!! Form::text('nom',$arbitre->nom, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			{!! Form::label('prenom', 'Prenom:') !!} 
			{!! Form::text('prenom',$arbitre->prenom, ['class' => 'form-control']) !!}
			{{ $errors->first('prenom') }}
		</div>
		<?php
			$regionArray = array();
			for ($i=0; $i<count($regions); $i++) {
				$regionArray[$i+1] = $regions[$i]['nom'];
			}
		?>
		<div class="form-group">
			{!! Form::label('region_id', 'Région :') !!} <br/>
			{!! Form::select('region_id', $regionArray, $arbitre->region_id) !!}
			{{ $errors->first('region_id') }}
		</div>
		<div class="form-group">
			{!! Form::label('numero_accreditation', 'Numéro accréditation :') !!} 
			{!! Form::text('numero_accreditation',$arbitre->numero_accreditation, ['class' => 'form-control']) !!}
			{{ $errors->first('numero_accreditation') }}
		</div>
		<div class="form-group">
			{!! Form::label('association', 'Association :') !!} 
			{!! Form::text('association',$arbitre->association, ['class' => 'form-control']) !!}
			{{ $errors->first('association') }}
		</div>
		<div class="form-group">
			{!! Form::label('numero_telephone', 'Numéro de téléphone :') !!} 
			{!! Form::text('numero_telephone',$arbitre->numero_telephone, ['class' => 'form-control']) !!}
			{{ $errors->first('numero_telephone') }}
		</div>
		<div class="form-group">
			{!! Form::label('adresse', 'Adresse :') !!} 
			{!! Form::text('adresse',$arbitre->adresse, ['class' => 'form-control']) !!}
			{{ $errors->first('adresse') }}
		</div>
		<div class="form-group">
			{!! Form::label('sexe', 'Sexe :') !!} 
			{!! Form::text('sexe',$arbitre->sexe, ['class' => 'form-control']) !!}
			{{ $errors->first('sexe') }}
		</div>
		<div class="form-group">
			{!! Form::label('date_naissance', 'Date de naissance:') !!} 
			{!! Form::text('date_naissance',$arbitre->date_naissance, ['class' => 'form-control']) !!}
			{{ $errors->first('date_naissance') }}
		</div>
		
		<div class="form-group">
			{!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop