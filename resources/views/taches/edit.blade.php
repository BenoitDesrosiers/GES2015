@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'une tâche</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('TachesController@update', $tache->id), 'method' => 'PUT', 'class' => 'form'])!!}
        <!--    Affiche les messages d'erreur après un enregistrement raté -->
        @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
		<div class="form-group">
			{!! Form::label('nom', 'Nom :') !!} 
			{!! Form::text('nom', $tache->nom, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
        <div class="form-group">
			{!! Form::label('description', 'Description :') !!} 
			{!! Form::text('description', $tache->description, ['class' => 'form-control']) !!}
			{{ $errors->first('prenom') }}
		</div>
		<div class="form-group">
			{!! Form::button('Modifier', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            <a href="{{ action('TachesController@show',$tache->id) }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop
