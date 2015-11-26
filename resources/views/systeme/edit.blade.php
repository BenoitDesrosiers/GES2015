@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification du titre de l'évenement</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('SystemeController@update', $id), 'method' => 'PUT', 'class' => 'form']) !!}
		<div class="form-group">
			{!! Form::label('texte', 'Changement de texte:') !!} 
			{!! Form::text('texte',$texte->nomEvenement, ['class' => 'form-control']) !!}
			{{ $errors->first('nomEvenement') }}
		</div>
		
		<div class="form-group">
			{!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close()!!}
	</div>
</div>
@stop