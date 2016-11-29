{{-----------------------------------------------------------------
| index.blade.php
| Description: Vue pour la page d'index des conditions particulières.
|              $conditionsParticulières doit être un array de
|              ConditionParticuliere.
| Créé le: 161120
| Modifié le: 161127
| Par: Res260
-----------------------------------------------------------------}}

@extends('conditionsParticulieres.master')
@section('titrePageConditionParticuliere', 'Conditions particulières')
@section('boutonEnTete')
    <a href="{!! URL::route('conditionsParticulieres.create') !!}" class="btn btn-md btn-info" >Créer une condition particulière</a>
@endsection
@push('stylesheets')
    <link rel="stylesheet" href="{!! asset('/css/conditionsParticulieres/index.css') !!}">
@endpush
@section('contenu')
    <div class="row">
        <div class="col-xs-6">
            <strong>Condition particulière</strong>
        </div>
    </div>
    @forelse($conditionsParticulieres as $condition)
        <div class="row contenu-condition-particuliere flex-ran">
            <div class="col-xs-8">
                <a href="{!! URL::route('conditionsParticulieres.show', $condition->id) !!}">
                    {{ $condition->nom }}
                </a>
            </div>
            <div class="col-xs-2">
                <a href="{!! URL::route('conditionsParticulieres.edit', $condition->id) !!}"
                        class="btn btn-md btn-primary">Modifier</a>
            </div>
            <div class="col-xs-2">
               {!! Form::open(['method' => 'delete', 'route' => ['conditionsParticulieres.destroy', $condition->id]]) !!}

                    <button type="submit" class="btn btn-md btn-danger">Supprimer</button>
                {!! Form::close() !!}
            </div>
        </div>
    @empty
        <div class="col-xs-12">
            <span>Aucune condition particulière.</span>
        </div>
    @endforelse
@endsection
