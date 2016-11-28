{{-----------------------------------------------------------------
| create.blade.php
| Description: Page de création pour une condition particulière.
| Créé le: 161126
| Modifié le: 161127
| Par: Res260
-----------------------------------------------------------------}}

@extends('conditionsParticulieres.master')
@section('titrePageConditionParticuliere', 'Créer une condition particulière')
@section('contenu')
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Des erreurs sont survenues lors de la validation des données:</strong><br />
            @foreach($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{!! URL::route('conditionsParticulieres.store') !!}">
        {!! csrf_field() !!}
        <div class="container-fluid no-padding">
            <div class="form-group {!! $errors->has('nom') ? 'has-error' : '' !!}">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="{{ old('nom') }}"
                       class="form-control" required />
            </div>
            <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                <label for="description">Description:</label>
                <input type="text" id="description" name="description"
                       value="{{ old('description') }}" class="form-control" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success btn-md"
                       value="Créer la condition particulière"/>
            </div>
        </div>
    </form>
@endsection
