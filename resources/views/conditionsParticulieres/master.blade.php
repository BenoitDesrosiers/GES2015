{{-----------------------------------------------------------------
| master.blade.php
| Description: Vue maître des autres vues du CRUD des conditions
|              particulières.
| Créé le: 161127
| Modifié le: 161127
| Par: Res260
-----------------------------------------------------------------}}

@extends('layout')
@section('content')
    @stack('stylesheets')
    @if(Session::has('message'))
        <div class="alert {!! Session::has('alert-class')
                        ? Session::get('alert-class')
                        : 'alert-info' !!}">
            <span>{!! Session::get('message') !!}</span>
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>@yield('titrePageConditionParticuliere')</h2>
            @yield('boutonEnTete')
        </div>
        <div class="container-fluid" id="conteneur-contenu">
            @yield('contenu')
        </div>
    </div>
@endsection
