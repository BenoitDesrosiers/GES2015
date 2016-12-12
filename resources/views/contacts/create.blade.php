@extends('layout')

@section('content')
	<div class="panel panel-default">
	    <div class="panel-heading">
	        <h2>Ajout d'un contact</h2>
	    </div>

	    <div class="panel-body">
	        {{ Form::open(['action'=> array('ContactsController@index', $organisme->id),'class' => 'form']) }}

	        @foreach ($errors->all() as $error)
	            <p class="alert alert-danger">{{ $error }}</p>
	        @endforeach

	        <div class="form-group">
	            {{ Form::label('prenom', '* Prénom:') }}
	            {{ Form::text('prenom', null, ['class' => 'form-control']) }}
	        </div>
	        <div class="form-group">
	            {{ Form::label('nom', '* Nom:') }}
	            {{ Form::text('nom', null, ['class' => 'form-control']) }}
	        </div>
	        <div class="form-group">
	            {{ Form::label('telephone', '* Telephone:') }} 
	            {{ Form::text('telephone', null, ['class' => 'form-control']) }}
	        </div>
	        <div class="form-group">
	            {{ Form::label('role', '* Rôle:') }} 
	            {{ Form::text('role', null, ['class' => 'form-control']) }}
	        </div>
	        <div class="form-group">
	            <p>*Champ obligatoire.</p>
	            {{ Form::button('Confirmer', ['action'=> 'ContactsController@store, $organisme->id', 'type' => 'submit', 'class' => 'btn btn-primary']) }}
	            <a href="{{ action('OrganismesController@show', $organisme->id) }}" class="btn btn-danger">Annuler</a>
	        </div>
	        {{ Form::close() }}
	    </div>
	</div>

@stop