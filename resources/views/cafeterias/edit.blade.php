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
        <h2>Modification de {{ $cafeteria->nom }}</h2>
    </div>
    <div class="panel-body" id="formulaire">
        {!! Form::open(['action'=> array('CafeteriasController@update', $cafeteria->id), 'method' => 'PUT', 'class' => 'form container-fluid']) !!}
        <div class="form-group">
            {!! Form::label('nom', '* Nom:') !!} 
            {!! Form::text('nom', $cafeteria->nom, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('adresse', '* Adresse:') !!} 
            {!! Form::text('adresse',$cafeteria->adresse, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('localisation', '* Localisation:') !!} 
            {!! Form::text('localisation', $cafeteria->localisation, ['class' => 'form-control']) !!}
        </div>
        <div id="responsables" class="form-group">
            {!! Form::label('responsable', '* Responsable:') !!}
           
            <div id="inputResponsables" class="form-group">
             @foreach ($cafeteria->responsable as $responsable)
                <div class="form-group row rangee">

                    <div class="col-xs-3">
                        <input type="text" name="responsable[0][nom]" placeholder="Nom" value="{{$responsable->nom}}" class="form-control" required>
                    </div>
                    <div class="col-xs-3">
                        <input type="text" name="responsable[0][telephone]" placeholder="Téléphone" value="{{$responsable->telephone}}" class="form-control" required>
                    </div>

                    <button type="button" class="btn btn-danger retirerResponsable">-</button>

                </div>
            @endforeach
            </div>
            
        </div>
        <div id="ajouterResponsable" class="form-group">
            {!! Form::button('Ajouter Responsable', ['class' => 'btn btn-success ajouterResponsable']) !!}
        </div>

        <div class="form-group">
            {!! Form::button('Modifier', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            <a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
@section('script')
    <script src="{!! asset('js/cafeteria.js') !!}"></script>
@stop