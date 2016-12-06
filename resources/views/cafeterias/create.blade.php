@extends('layout')
@section('stylesheet')
    <link rel="stylesheet" href="{!! asset('/css/cafeteria.css') !!}">
@stop
@section('content')

<!-- Message d'erreurs. -->
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
        </ul>
    </div>
@endif

<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Création d'une cafétéria</h2>
    </div>
    <div class="panel-body" id="formulaire">
        {!! Form::open(['action'=> 'CafeteriasController@index', 'class' => 'form container-fluid']) !!}
        <div class="form-group">
            {!! Form::label('nom', '* Nom:') !!} 
            {!! Form::text('nom',null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('adresse', '* Adresse:') !!} 
            {!! Form::text('adresse',null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('localisation', '* Localisation:') !!} 
            {!! Form::text('localisation', null, ['class' => 'form-control']) !!}
        </div>
        <div id="responsables" class="form-group">
        {!! Form::label('responsable', '* Responsable:') !!}
    		<div id="inputResponsables" class="form-group">
                <div class="form-group row rangee">

                    <div class="col-xs-3">
                        <input type="text" name="responsable[0][nom]" placeholder="Nom" class="form-control" required>
                    </div>
                    <div class="col-xs-3">
                        <input type="text" name="responsable[0][telephone]" placeholder="Téléphone" class="form-control" required>
                    </div>
                </div>
            </div>
            
        </div>
        <div id="ajouterResponsable" class="form-group">
            {!! Form::button('Ajouter Responsable', ['class' => 'btn btn-success ajouterResponsable']) !!}
        </div>
        <div class="form-group">
            {!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary', 'name' => 'submit']) !!}
            <a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
@section('script')
    <script src="{!! asset('js/cafeteria.js') !!}"></script>
@stop