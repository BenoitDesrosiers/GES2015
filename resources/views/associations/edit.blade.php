@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'une association</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('AssociationsController@update', $association->id), 'method' => 'PUT', 'class' => 'form']) !!}
		<div class="form-group">
			<!--  L'emplacement où est affiché le nom d'une associarion -->
			<!--  Le nom peut être modifié  -->
			<!--  !!Obligatoire!! -->
			{!! Form::label('nom', 'Nom:') !!} 
			{!! Form::text('nom',$association->nom, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			<!--  L'emplacement où est affichée l'abréviation d'une associarion -->
			<!--  L'abreviation peut être modifiée  -->
			<!--  !!Obligatoire!! -->
			{!! Form::label('abreviation', 'Abréviation:') !!}
			{!! Form::text('abreviation',$association->abreviation, ['class' => 'form-control']) !!}
			{{ $errors->first('abreviation') }}
		</div>
		<div class="form-group">
			<!--  L'emplacement où est affichée la description d'une associarion -->
			<!--  La description peut être modifiée  -->
			{!! Form::label('description', 'Description:') !!} 
			{!! Form::text('description',$association->description, ['class' => 'form-control']) !!}
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