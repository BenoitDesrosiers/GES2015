@extends('layout')
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('/css/dateHeure.css') }}">
@stop
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Création d'un événement</h2>
    </div>
    <div class="panel-body">
        {!! Form::open(['action'=> 'EvenementsController@index', 'class' => 'form']) !!}
        @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="form-group">
            {!! Form::label('nom', '* Nom:') !!} 
            {!! Form::text('nom',null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group dateHeure">
            {!! Form::label('date', '* Date:') !!}
            {!! Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group dateHeure">
            {!! Form::label('heure', '* Heure:') !!}
            {!! Form::time('heure', "12:00", ['class' => 'form-control']) !!}
        </div>
        <?php
            $typeArray = array();
            for ($i=0; $i<count($types); $i++) {
                $typeArray[$types[$i]['id']]  = $types[$i]['titre'];
            }
        ?>
        <div class="form-group">
            {!! Form::label('type_id', '* Type:') !!} <br/>
            {!! Form::select('type_id', $typeArray, null, ['class' => 'form-control largeurPetite']) !!}
        </div>
        <?php
            $epreuveArray = array();
            for ($i=0; $i<count($epreuves); $i++) {
                $epreuveArray[$epreuves[$i]['id']]  = $epreuves[$i]['nom'];
            }
        ?>
        <div class="form-group">
            {!! Form::label('epreuve_id', '* Épreuve:') !!} <br/>
            {!! Form::select('epreuve_id', $epreuveArray, null, ['class' => 'form-control largeurPetite']) !!}
        </div>
        <?php
            $terrainArray = array();
            for ($i=0; $i<count($terrains); $i++) {
                $terrainArray[$terrains[$i]['id']]  = $terrains[$i]['nom'];
            }
        ?>
        <div class="form-group">
            {!! Form::label('terrain_id', '* Terrain:') !!} <br/>
            {!! Form::select('terrain_id', $terrainArray, null, ['class' => 'form-control largeurPetite']) !!}
        </div>
        <div class="form-group">
            {!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            <a href="{{ action('EvenementsController@index') }}" class="btn btn-danger">Annuler</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop