@extends('layout')
@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Liste des Terrains</h2>
        <a href="{{ action('TerrainsController@create') }}" class="btn btn-info">Créer un terrain</a>                       
    </div>
@if ($terrains->isEmpty())
    <div class="panel-body">
        <p>Aucun terrain</p>
    </div>
@else
    <table class="table table-striped table-hover">
        <thead>
            <tr>
        <!-- Titre des colonnes du tableau (s'adapte aux différentes dimensions selon les types de Bootstrap) -->
                <th>Nom</th>
                <th class="hidden-xs">Adresse</th>
                <th class="hidden-xs">Ville</th>
                <th class="hidden-xs">Région</th>
                <th class="hidden-sm hidden-xs">Description</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
@foreach($terrains as $terrain)

        <!-- Ajout de chaque terrain de la base de données dans table des terrains -->
            <tr>
                <td><a href="{{ action('TerrainsController@show', $terrain->id) }}">{{ $terrain->nom }}</a></td>
                <td class="hidden-xs"><?php if ($terrain->adresse == "") {echo "Aucune adresse";} else {echo $terrain->adresse;} ?></td>
                <td class="hidden-xs"><?php if ($terrain->ville == "") {echo "Aucune ville";} else {echo $terrain->ville;} ?></td>
                <td class="hidden-xs"><span>{{$terrain->region->nom_court}}</span></td>
                <td class="hidden-sm hidden-xs"><?php if ($terrain->description_courte == "") {echo "Aucune description";} else {echo $terrain->description_courte;} ?></td>
                <td><a href="{{ action('TerrainsController@edit',$terrain->id) }}" class="btn btn-info">Modifier</a></td>
                <td>{!! Form::open(array('action' => array('TerrainsController@destroy',$terrain->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
                    <button type="submit" href="{{ URL::route('terrains.destroy', $terrain->id) }}" class="btn btn-danger btn-mini">Effacer</button>
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