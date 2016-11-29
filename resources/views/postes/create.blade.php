@extends('layout')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Création d'un poste</h2>
        </div>
        <div class="panel-body">
            {!! Form::open(['action'=> 'PostesController@index', 'class' => 'form']) !!}
            @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
            <div class="form-group">
                {!! Form::label('nom', 'Nom:') !!}
                {!! Form::text('nom',null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description:') !!}
                {!! Form::text('description',null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                <a href="{{ action('PostesController@index') }}" class="btn btn-danger">Annuler</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop