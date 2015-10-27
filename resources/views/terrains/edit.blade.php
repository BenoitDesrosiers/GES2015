@extends('layout')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Modification d'un terrain</h2>
    </div>
    <div class="panel-body">
        {!! Form::open(['action'=> array('TerrainsController@update', $terrain->id), 'method' => 'PUT', 'class' => 'form']) !!}
        <div class="form-group">
            {!! Form::label('nom', 'Nom:') !!} 
            {!! Form::text('nom',$terrain->nom, ['class' => 'form-control']) !!}
            {{ $errors->first('nom') }}
        </div>
        <div class="form-group">
            {!! Form::label('adresse', 'Adresse:') !!} 
            {!! Form::text('adresse',$terrain->adresse, ['class' => 'form-control']) !!}
            {{ $errors->first('adresse') }}
        </div>
        <div class="form-group">
            {!! Form::label('ville', 'Ville:') !!} 
            {!! Form::text('ville',$terrain->ville, ['class' => 'form-control']) !!}
            {{ $errors->first('ville') }}
        </div>
        <?php
            $regionArray = array();
            for ($i=0; $i<count($regions); $i++) {
                $regionArray[$i+1] = $regions[$i]['nom'];
            }
        ?>
        <div class="form-group">
            {!! Form::label('region_id', 'Région:') !!} <br/>
            {!! Form::select('region_id', $regionArray, $terrain->region_id) !!}
            {{ $errors->first('region_id') }}
        </div>
        <div class="form-group">
            {!! Form::label('description_courte', 'Description:') !!} 
            {!! Form::text('description_courte',$terrain->description_courte, ['class' => 'form-control']) !!}
            {{ $errors->first('description_courte') }}
        </div>
        <div class="form-group">
            {!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            <a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop