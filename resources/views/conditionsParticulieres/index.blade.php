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
    <link rel="stylesheet" href="{!! asset('/css/conditionsParticulieres/index.css') !!}">
    @if(Session::has('message'))
        <div class="alert {!! Session::has('alert-class')
                                ? Session::get('alert-class')
                                : 'alert-info' !!}">
            <span>{!! Session::get('message') !!}</span>
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Conditions particulières</h2>
            <a href="{!! URL::route('conditionsParticulieres.create') !!}"
               class="btn btn-md btn-info">Créer une condition particulière</a>
        </div>
        <div class="container-fluid" id="conteneur-conditions-particulieres">
            <div class="row">
                <div class="col-xs-6">
                    <strong>Condition particulière</strong>
                </div>
            </div>
            @foreach($conditionsParticulieres as $condition)
                <div class="row contenu-condition-particuliere flex-ran">
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
                       {!! Form::open(['method' => 'delete', 'route' => ['conditionsParticulieres.destroy', $condition->id]]) !!}

                            <button type="submit" class="btn btn-md btn-danger">Supprimer</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
