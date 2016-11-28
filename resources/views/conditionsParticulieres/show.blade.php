{{-----------------------------------------------------------------
| show.blade.php
| Description: Vue pour la page d'affichage d'une condition
|              particulière. $condition doit être une
|              ConditionParticuliere.
| Créé le: 161122
| Modifié le: 161127
| Par: Res260
-----------------------------------------------------------------}}

@extends('conditionsParticulieres.master')
@section('titrePageConditionParticuliere', $condition->nom)
@section('contenu')
    <div class="row">
        @if($condition->description)
            <strong>Description:</strong>
            <span>{{ $condition->description }}</span>
        @else
            <em>Aucune description.</em>
        @endif
    </div>
    <div class="row">
        <strong>Créée le:</strong>
        <span>{!! $condition->created_at !!}</span>
    </div>
    <div class="row">
        <strong>Modifiée le:</strong>
        <span>{!! $condition->updated_at !!}</span>
    </div>
    <div class="row">
        <a href="{!! URL::route('conditionsParticulieres.index') !!}" class="btn btn-md btn-primary">Retour</a>
    </div>
@endsection
