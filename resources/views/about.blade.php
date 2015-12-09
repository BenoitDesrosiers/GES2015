@extends('layout')
@section('content')
    <!-- Jumbotron -->
    <div class="jumbotron">
        <h1>À propos</h1>
        <p class="lead">Liste des étudiants qui ont participés!</p>
    </div>

@if (count($liste_etudiants) === 0)
    <div class="panel-body">
        <p>Aucun étudiants</p>
    </div>
@else
    @foreach($liste_etudiants as $annee => $etudiants)

        @if (count($etudiants) === 0)
            <div class="panel-body">
                <p>Aucun étudiants</p>
            </div>
        @else
            <p>Années : {{ $annee }}</p>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                <!-- Titre des colonnes du tableau (s'adapte aux différentes dimensions selon les types de Bootstrap) -->
                        <th>Nom</th>
                        <th>Commentaires</th>
                    </tr>
                </thead>
                <tbody>
        @foreach($etudiants as $etudiant)

                <!-- Ajout de chaque terrain de la base de données dans table des terrains -->
                    <tr>
                        <td>{{ $etudiant[0] }}</td>
                        <td>{{ $etudiant[1] }}</td>
                    </tr>
        @endforeach
        @endif
                </tbody>
            </table>

    @endforeach
@endif
@stop
