@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'un code</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('CodesController@update', $code->id), 'method' => 'PUT', 'class' => 'form']) !!}
		<div class="form-group">
			<!--  L'emplacement où est affiché le nom d'un code -->
			<!--  Le nom peut être modifié  -->
			<!--  !!Obligatoire!! -->
			{!! Form::label('nom', 'Nom:') !!} 
			{!! Form::text('nom',$code->nom, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			<!--  L'emplacement où est affichée l'abréviation d'un code -->
			<!--  L'abreviation peut être modifiée  -->
			<!--  !!Obligatoire!! -->
			{!! Form::label('abreviation', 'Abréviation:') !!}
			{!! Form::text('abreviation',$code->abreviation, ['class' => 'form-control']) !!}
			{{ $errors->first('abreviation') }}
		</div>
		<div class="form-group">
			<!--  L'emplacement où est affichée la description d'un code -->
			<!--  La description peut être modifiée  -->
			{!! Form::label('description', 'Description:') !!} 
			{!! Form::text('description',$code->description, ['class' => 'form-control']) !!}
			{{ $errors->first('description') }}
		</div>

		<div class="form-group">
			{!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop