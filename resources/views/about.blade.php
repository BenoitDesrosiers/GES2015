@extends('layout')
@section('content')
    <!-- Jumbotron -->
    <div class="jumbotron">
        <h1>À propos</h1>
        <p class="lead">Gestion d'évènements sportifs</p>
    </div>
	<div>
		<p>Ce système permettra, un jour, de faire la gestion complète d'un évènement sportif. Il a été conçu suite aux Jeux du Québec ayant eu lieu à Drummondville à l'hiver 2015. </p>
		<p>La conception originale du projet a été réalisée par Benoit Desrosiers dans le cadre du cours 420-CN2-DM du cégep de Drummondville.</p>
		<p>Les étudiants du cours donné à l'automne 2014 ont réalisé la base du système. Ils ont réalisé les pages originales pour la gestion des sports, épreuves, participants, et résultats. </p>
		<p>De toutes les versions remises en 2014, c'est celle de François Allard qui a été utilisé pour continuer le projet.</p>
		<p>À l'automne 2015, les étudiants du cours CN2 ont continué le développement du projet en ajoutant divers composants et en améliorant ceux déjà existants</p> 
		</br>
		<p>Le site est développé en PHP à l'aide du framework Laravel. Il est entreposé sur GitHub: <a href="https://github.com/BenoitDesrosiers/GES2015.git">https://github.com/BenoitDesrosiers/GES2015.git</a></p>
		</br>
		 <p class="lead">Liste des étudiants ayant participé!</p>
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
