{{-----------------------------------------------------------------
| edit.blade.php
| Description: Page de modification pour une condition particulière.
|              $condition doit être accessible et être une
|              ConditionParticuliere.
| Créé le: 161127
| Modifié le: 161127
| Par: Res260
-----------------------------------------------------------------}}

@extends('conditionsParticulieres.master')
@section('titrePageConditionParticuliere', 'Modifier: ' . $condition->nom)
@section('contenu')
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Des erreurs sont survenues lors de la validation des données:</strong><br />
            @foreach($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
        </div>
    @endif
    {!! Form::open(['action' => ['ConditionsParticulieresController@update', $condition->id],
                    'method' => 'PUT']) !!}
        <div class="container-fluid">
            <div class="form-group {!! $errors->has('nom') ? 'has-error' : '' !!}">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom"
                       value="{{ $condition->nom }}" class="form-control" />
            </div>
            <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                <label for="description">Description:</label>
                <input type="text" id="description" name="description"
                       value="{{ $condition->description }}" class="form-control" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success btn-md"
                       value="Modifier la condition particulière"/>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
