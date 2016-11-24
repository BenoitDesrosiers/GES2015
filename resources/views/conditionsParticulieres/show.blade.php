{{-----------------------------------------------------------------
| show.blade.php
| Description: Vue pour la page d'affichage d'une condition
|              particulière. $condition doit être une
|              ConditionParticuliere.
| Créé le: 161122
| Modifié le: 161122
| Par: Res260
-----------------------------------------------------------------}}

@extends('layout')
@section('content')
    <link rel="stylesheet" href="{!! asset('/css/conditionsParticulieres/index.css') !!}">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>{{ $condition->nom }}</h2>
        </div>
        <div class="container-fluid">
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
        </div>
    </div>
@endsection
