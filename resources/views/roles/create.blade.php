@extends('layout')
@section('content')

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Création d'un rôle</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> 'RolesController@index', 'class' => 'form']) !!}
		<div class="form-group">
			{!! Form::label('nom', 'Nom:') !!}
			{!! Form::text('nom',null, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			{!! Form::label('description', 'Description:') !!} 
			{!! Form::text('description',null, ['class' => 'form-control']) !!}
			{{ $errors->first('description') }}
		</div>
		<div class="form-group">
			{!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop