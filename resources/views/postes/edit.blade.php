@extends('layout')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Modification d'un poste</h2>
        </div>
        <div class="panel-body">
            {!! Form::open(['action'=> array('PostesController@update', $poste->id), 'method' => 'PUT', 'class' => 'form']) !!}
            @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
            <div class="form-group">
                {!! Form::label('nom', 'Nom:') !!}
                {!! Form::text('nom',$poste->nom, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description:') !!}
                {!! Form::text('description',$poste->description, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                <a href="{{ action('PostesController@index') }}" class="btn btn-danger">Annuler</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop