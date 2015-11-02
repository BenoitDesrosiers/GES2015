@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Création d'un bénévole</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> 'BenevolesController@index', 'class' => 'form']) !!}
		<div class="form-group">
			{!! Form::label('nom', 'Nom :') !!} 
			{!! Form::text('nom',null, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
        <div class="form-group">
			{!! Form::label('adresse', 'Adresse :') !!} 
			{!! Form::text('adresse',null, ['class' => 'form-control']) !!}
			{{ $errors->first('adresse') }}
		</div>
        <div class="form-group">
			{!! Form::label('numTel', 'Numéro de téléphone :') !!} 
			{!! Form::text('numTel',null, ['class' => 'form-control']) !!}
			{{ $errors->first('numTel') }}
		</div>
        <div class="form-group">
			{!! Form::label('numCell', 'Numéro de cellulaire :') !!} 
			{!! Form::text('numCell',null, ['class' => 'form-control']) !!}
			{{ $errors->first('numCell') }}
		</div>
        <div class="form-group">
			{!! Form::label('courriel', 'Courriel :') !!} 
			{!! Form::text('courriel',null, ['class' => 'form-control']) !!}
			{{ $errors->first('courriel') }}
		</div>
        <div class="form-group">
			{!! Form::label('disponibilite', 'Disponibilité :') !!} 
			{!! Form::text('disponibilite',null, ['class' => 'form-control']) !!}
			{{ $errors->first('disponibilite') }}
		</div>
        <div class="form-group">
			{!! Form::label('accreditation', 'Accréditation :') !!} 
			{!! Form::text('accreditation',null, ['class' => 'form-control']) !!}
			{{ $errors->first('accreditation') }}
		</div>
        <div class="form-group">
			{!! Form::label('verification', 'Vérification :') !!} 
			{!! Form::checkbox('verification',null, ['class' => 'form-control']) !!}
			{{ $errors->first('verification') }}
		</div>	
		<div class="form-group">
			{!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop
