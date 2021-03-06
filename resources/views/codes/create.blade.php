@extends('layout')
@section('content')

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Création d'un code</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> 'CodesController@index', 'class' => 'form']) !!}
		<!--    Affiche les messages d'erreur après un enregistrement raté -->
        @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
		<div class="form-group">
			<!--  L'emplacement où l'on entre le nom du nouveau code -->
			<!--  !!Obligatoire!! -->
			{!! Form::label('nom', 'Nom:') !!}
			{!! Form::text('nom',null, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			<!--  L'emplacement où l'on entre l'abréviation du nouveau code -->
			<!--  !!Obligatoire!! -->
			{!! Form::label('abreviation', 'Abréviation:') !!}
			{!! Form::text('abreviation',null, ['class' => 'form-control']) !!}
			{{ $errors->first('abreviation') }}
		</div>
		<div class="form-group">
			<!--  L'emplacement où l'on entre la description du nouveau code -->
			<!--  Peut être vide! -->
			{!! Form::label('description', 'Description:') !!} 
			{!! Form::text('description',null, ['class' => 'form-control']) !!}
			{{ $errors->first('description') }}
		</div>
		<div class="form-group">
			{!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ action('CodesController@index') }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop