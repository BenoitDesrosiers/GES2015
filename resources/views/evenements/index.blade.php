@extends('layout')
@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Liste des Événements</h2>
        <a href="{{ action('EvenementsController@create') }}" class="btn btn-info">Créer un événement</a>
    </div>
@if ($evenements->isEmpty())
    <div class="panel-body">
        <p>Aucun événement</p>
    </div>
@else
    <table class="table table-striped table-hover">
        <thead>
            <tr>
        <!-- Titre des colonnes du tableau (s'adapte aux différentes dimensions selon les types de Bootstrap) -->
                <th>Nom</th>
                <th class="hidden-xs">Date</th>
                <th class="hidden-xs">Type</th>
                <th class="col-sm-1"></th>
                <th class="col-sm-1"></th>
            </tr>
        </thead>
        <tbody>
@foreach($evenements as $evenement)

        <!-- Ajout de chaque événement de la base de données dans table des événements -->
            <tr>
                <td><a href="{{ action('EvenementsController@show', $evenement->id) }}">{{ $evenement->nom }}</a></td>
                <td class="hidden-xs">{{substr($evenement->date_heure, 0, 16)}}</td>
                <td class="hidden-xs">{{$evenement->type->titre}}</td>
                <td><a href="{{ action('EvenementsController@edit',$evenement->id) }}" class="btn btn-info">Modifier</a></td>
                <td>{!! Form::open(array('action' => array('EvenementsController@destroy',$evenement->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
                    <button type="submit" href="{{ URL::route('evenements.destroy', $evenement->id) }}" class="btn btn-danger btn-mini">Effacer</button>
                    {!! Form::close() !!}   {{-- méthode pour faire le delete tel que décrit sur http://www.codeforest.net/laravel-4-tutorial-part-2 , 
                                            un script js est appelé pour tous les form qui ont un "data-confirm" (voir assets/js/script.js) --}}
                </td>
            </tr>
@endforeach
        </tbody>
    </table>
@endif
</div>
@stop