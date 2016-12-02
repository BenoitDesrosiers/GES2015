@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'une association</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('AssociationsController@update', $association->id), 'method' => 'PUT', 'class' => 'form']) !!}
		@foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
		<div class="form-group">
			<!--  L'emplacement où est affiché le nom d'une association -->
			<!--  Le nom peut être modifié  -->
			<!--  !!Obligatoire!! -->
			{!! Form::label('nom', 'Nom:') !!} 
			{!! Form::text('nom',$association->nom, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			<!--  L'emplacement où est affichée l'abréviation d'une association -->
			<!--  L'abreviation peut être modifiée  -->
			<!--  !!Obligatoire!! -->
			{!! Form::label('abreviation', 'Abréviation:') !!}
			{!! Form::text('abreviation',$association->abreviation, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			<!--  L'emplacement où est affichée la description d'une association -->
			<!--  La description peut être modifiée  -->
			{!! Form::label('description', 'Description:') !!} 
			{!! Form::text('description',$association->description, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ action('AssociationsController@index') }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop