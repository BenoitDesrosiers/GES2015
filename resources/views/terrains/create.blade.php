@extends('layout')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Création d'un terrain</h2>
    </div>
    <?php //todo: ajouter la liste des erreurs en rouge en haut?>
    <div class="panel-body">
        {!! Form::open(['action'=> 'TerrainsController@index', 'class' => 'form']) !!}
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
            {!! Form::label('ville', '* Ville:') !!} 
            {!! Form::text('ville', null, ['class' => 'form-control']) !!}
            {{ $errors->first('ville') }}
        </div>
        <?php
            $regionArray = array();
            for ($i=0; $i<count($regions); $i++) {
                $regionArray[$i+1] = $regions[$i]['nom'];
            }
        ?>
        <div class="form-group">
            {!! Form::label('region_id', '* Région:') !!} <br/>
            {!! Form::select('region_id', $regionArray) !!}
            {{ $errors->first('region_id') }}
        </div>
        <div class="form-group">
            {!! Form::label('description_courte', 'Description:') !!} 
            {!! Form::text('description_courte',null, ['class' => 'form-control']) !!}
            {{ $errors->first('description_courte') }}
        </div>
        <div class="form-group">
            {!! Form::label('sports', 'Sports:') !!} 
            <div class="row">
                <?php
                    foreach ($sports as $sport) {
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 button-group" data-toggle="buttons">
                    <label class="btn btn-default btn-block">
                        <input name="sport[{{ $sport->id }}]" type="checkbox"> {{ $sport->nom }}
                    </label><br/>
                </div>
                <?php
                    }
                ?>
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