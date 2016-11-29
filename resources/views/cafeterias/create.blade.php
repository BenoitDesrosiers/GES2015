@extends('layout')
@section('stylesheet')
    <link rel="stylesheet" href="{!! asset('/css/cafeteria.css') !!}">
@stop
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Création d'une cafétéria</h2>
    </div>
    <div class="panel-body" id="formulaire">
        {!! Form::open(['action'=> 'CafeteriasController@index', 'class' => 'form container-fluid']) !!}
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
        <div id="responsables">
    		<div class="form-group row rangee">

                <div class="col-xs-12">
                    {!! Form::label('responsable', '* Responsable:') !!}
                </div>

                <div class="col-xs-3">
                    <input type="text" name="responsableNom[]" placeholder="Nom" class="form-control" required>
                    {{ $errors->first('responsableNom') }}
                </div>
                <div class="col-xs-3">
                    <input type="text" name="responsableTelephone[]" placeholder="Téléphone" class="form-control" required>
                    {{ $errors->first('responsableTelephone') }}
                </div>

                <div class="col-xs-1">
                    {!! Form::button('+', ['class' => 'btn btn-success ajouterResponsable dernierAjout']) !!}
                </div>
            </div>
        </div>

        <div class="form-group">
            {!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            <a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
@section('script')
    <script src="{!! asset('js/cafeteria.js') !!}"></script>
@stop