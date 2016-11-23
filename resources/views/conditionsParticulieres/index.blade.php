{{-----------------------------------------------------------------
| index.blade.php
| Description: Vue pour la page d'index des conditions particulières.
|              $conditionsParticulières doit être un array de
|              ConditionParticuliere.
| Créé le: 161120
| Modifié le: 161122
| Par: Res260
-----------------------------------------------------------------}}

@extends('layout')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Conditions particulières</h2>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-6">
                    <strong>Condition particulière</strong>
                </div>
            </div>
            @foreach($conditionsParticulieres as $condition)
                <div class="row contenu-condition-particuliere">
                    <div class="col-xs-8">
                        <a href="{!! URL::route('conditionsParticulieres.show', $condition->id) !!}">
                            {{ $condition->nom }}
                        </a>
                    </div>
                    <div class="col-xs-2">
                        <button href="{!! URL::route('conditionsParticulieres.edit', $condition->id) !!}"
                                class="btn btn-md btn-primary">Modifier</button>
                    </div>
                    <div class="col-xs-2">
                        <button href="{!! URL::route('conditionsParticulieres.destroy', $condition->id) !!}"
                                class="btn btn-md btn-danger">Supprimer</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
