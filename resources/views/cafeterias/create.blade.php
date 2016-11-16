@extends('layout')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Création d'une cafétéria</h2>
    </div>
    <div class="panel-body">
        {!! Form::open(['action'=> 'CafeteriasController@index', 'class' => 'form']) !!}
        <div class="form-group">
            {!! Form::label('nom', '* Nom:') !!} 
            {!! Form::text('nom',null, ['class' => 'form-control']) !!}
            {{ $errors->first('nom') }}
        </div>

        <div class="form-group">
            {!! Form::label('adresse', '* Adresse:') !!} 
            {!! Form::text('adresse',null, ['class' => 'form-control']) !!}
            {{ $errors->first('adresse') }}
        </div>

        <div class="form-group">
            {!! Form::label('localisation', '* Localisation:') !!} 
            {!! Form::text('localisation', null, ['class' => 'form-control']) !!}
            {{ $errors->first('localisation') }}
        </div>
        
		<div class="form-group">
            {!! Form::label('responsable', '* Responsable:') !!} 
            {!! Form::text('responsableNom', 'Nom', ['class' => 'form-control']) !!}
            {{ $errors->first('responsableNom') }}
            {!! Form::text('responsableTelephone', 'Téléphone', ['class' => 'form-control']) !!}
            {{ $errors->first('responsableTelephone') }}
        </div>

        <div class="form-group">
            {!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            <a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop