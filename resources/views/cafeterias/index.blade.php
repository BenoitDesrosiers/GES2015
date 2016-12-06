@extends('layout')
@section('content')

<!-- Message de succes. -->
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<!-- Message d'erreur. -->
@if (session('erreur'))
    <div class="alert alert-danger">
        {{ session('erreur') }}
    </div>
@endif

<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Liste des cafétérias</h2>
        <a href="{{ action('CafeteriasController@create') }}" class="btn btn-info">Créer une cafétéria</a>                       
    </div>
    @if ($cafeterias->isEmpty())
	    <div class="panel-body">
	        <p>Aucune cafétéria</p>
	    </div>
	@else
		<table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Localisation</th>                
            </tr>
        </thead>
        <tbody>
        @foreach($cafeterias as $cafeteria)
            <tr>
                <td><a href="{{ action('CafeteriasController@show', $cafeteria->id) }}">{{ $cafeteria->nom }}</a></td>
                <td>{{$cafeteria->adresse}}</td>
                <td>{{$cafeteria->localisation}}</td>
                <td><a href="{{ action('CafeteriasController@edit',$cafeteria->id) }}" class="btn btn-info">Modifier</a></td>
                <!-- Boutton pris des autres indexs du projet -->
                <td>{!! Form::open(array('action' => array('CafeteriasController@destroy',$cafeteria->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
                    <button type="submit" href="{{ URL::route('cafeterias.destroy', $cafeteria->id) }}" class="btn btn-danger btn-mini">Effacer</button>
                    {!! Form::close() !!}   {{-- méthode pour faire le delete tel que décrit sur http://www.codeforest.net/laravel-4-tutorial-part-2 , 
                                            un script js est appelé pour tous les form qui ont un "data-confirm" (voir assets/js/script.js) --}}
                </td>
            </tr>
        @endforeach
        </tbody>
    @endif
</div>
@stop