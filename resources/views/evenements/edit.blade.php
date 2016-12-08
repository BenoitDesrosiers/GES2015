@extends('layout')
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('/css/dateHeure.css') }}">
@stop
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Modification d'un événement</h2>
    </div>
    <div class="panel-body">
        {!! Form::open(['action'=> array('EvenementsController@update', $evenement->id), 'method' => 'PUT', 'class' => 'form']) !!}
        @foreach ($errors->all() as $error)
        <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        {!! Form::hidden('id', $evenement->id) !!}
        <div class="form-group">
            {!! Form::label('nom', '* Nom:') !!} 
            {!! Form::text('nom', $evenement->nom, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group dateHeure">
            {!! Form::label('date', '* Date:') !!}
            {!! Form::date('date', $date, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group dateHeure">
            {!! Form::label('heure', '* Heure:') !!}
            {!! Form::time('heure', $heure, ['class' => 'form-control']) !!}
        </div>
        <?php
            $typeArray = array();
            for ($i=0; $i<count($types); $i++) {
                $typeArray[$types[$i]['id']]  = $types[$i]['titre'];
            }
        ?>
        <div class="form-group">
            {!! Form::label('type_id', '* Type:') !!} <br/>
            {!! Form::select('type_id', $typeArray, $evenement->type_id, ['class' => 'form-control largeurPetite']) !!}
        </div>
        <?php
            $epreuveArray = array();
            for ($i=0; $i<count($epreuves); $i++) {
                $epreuveArray[$epreuves[$i]['id']]  = $epreuves[$i]['nom'];
            }
        ?>
        <div class="form-group">
            {!! Form::label('epreuve_id', '* Épreuve:') !!} <br/>
            {!! Form::select('epreuve_id', $epreuveArray, $evenement->epreuve_id, ['class' => 'form-control largeurPetite']) !!}
        </div>
        <?php
            $terrainArray = array();
            for ($i=0; $i<count($terrains); $i++) {
                $terrainArray[$terrains[$i]['id']]  = $terrains[$i]['nom'];
            }
        ?>
        <div class="form-group">
            {!! Form::label('terrain_id', '* Terrain:') !!} <br/>
            {!! Form::select('terrain_id', $terrainArray, $evenement->terrain_id, ['class' => 'form-control largeurPetite']) !!}
        </div>
        <div class="form-group">
            {!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            <a href="{{ action('EvenementsController@index') }}" class="btn btn-danger">Annuler</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop