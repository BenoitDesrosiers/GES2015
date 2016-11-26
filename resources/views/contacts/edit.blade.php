@extends('layout')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification du contact: {{ $contact->prenom }} {{ $contact->nom }}</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('ContactsController@update', $organisme->id, $contact->id), 'method' => 'PUT', 'class' => 'form']) !!}

        @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
        @endforeach

        <div class="form-group">
            {!! Form::label('prenom', '*Prénom:') !!} 
            {!! Form::text('prenom', $contact->prenom, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('nom', '*Nom:') !!}
            <br/>
            {!! Form::text('nom', $contact->nom, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('telephone', '*Téléphone:') !!}
            <br/>
            {!! Form::text('telephone', $contact->telephone, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('role', '*Role:') !!} 
            {!! Form::text('role', $contact->role, ['class' => 'form-control']) !!}
        </div>
		<div class="form-group">
			{!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ action('OrganismesController@show', [$organisme->id, $contact->id]) }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>

@stop