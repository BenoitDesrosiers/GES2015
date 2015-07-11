@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Édition d'une épreuve</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> ['SportsEpreuvesController@update', $sport->id], 'class' => 'form']) !!}
		<div class="form-group">
			{!! Form::label('nom', 'Nom:') !!} 
			{!! Form::text('nom',$epreuve->nom, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			{!! Form::label('description', 'Description courte:') !!} 
			{!! Form::text('description',$epreuve->description, ['class' => 'form-control']) !!}
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