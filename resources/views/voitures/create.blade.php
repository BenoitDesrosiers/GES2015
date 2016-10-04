@extends('layout')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Création d'une voiture</h2>
    </div>
    <div class="panel-body">
        {!! Form::open(['action'=> 'VoituresController@index', 'class' => 'form']) !!}
        <div class="form-group">
            {!! Form::label('modele', '* Modèle:') !!} 
            {!! Form::text('modele',null, ['class' => 'form-control']) !!}
            {{ $errors->first('modele') }}
        </div>
        <div class="form-group">
            {!! Form::label('date_achat', "* Date de l'achat:") !!} 
            {!! Form::text('date_achat',null, ['class' => 'form-control']) !!}
            {{ $errors->first('date_achat') }}
        </div>
        <div class="form-group">
            {!! Form::label('identifiant', '* Identifiant:') !!} 
            {!! Form::text('identifiant',null, ['class' => 'form-control']) !!}
            {{ $errors->first('identifiant') }}
        </div>
        <div class="form-group">
            {!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            <a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop