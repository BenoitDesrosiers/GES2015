@extends('layout')
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('/css/organismesCSS.css') }}">
@stop

@section('content')
<div class="panel panel-default">

    <div class="panel-heading">
        <h2>Création d'un organisme</h2>
    </div>

    <div class="panel-body">
        {!! Form::open(['action'=> 'OrganismesController@index','class' => 'form']) !!}

        @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

        <div class="form-group">
            {!! Form::label('nomOrganisme', '* Nom organisme:') !!} 
            {!! Form::text('nomOrganisme', null, ['class' => 'form-control nomOrganismeBoite']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('telephone', 'Téléphone:') !!}
            <br/>
            {!! Form::text('telephone', null, ['class' => 'form-control telephone']) !!}
            <small class="form-text text-muted">ex: 819-123-4567, (819) 123-4567</small>
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Description:') !!} 
            {!! Form::text('description', null, ['class' => 'form-control boiteDescription']) !!}
        </div>
        <div class="form-group">
            <p>*Champ obligatoire.</p>
            {!! Form::button('Confirmer', ['action'=> 'OrganismesController@store', 'type' => 'submit', 'class' => 'btn btn-primary']) !!}
            <a href="{{ action('OrganismesController@index') }}" class="btn btn-danger">Annuler</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop