@extends('layout')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Création de participants</h2>
            <div id="aide">
                Votre fichier CSV doit suivre les règles suivantes:
                <ul>
                    <li>Avoir au minimum le même nombre de colonnes que le tableau</li>
                    <li>Les sports auxquels les participants participent font partie des colonnes supplémentaires</li>
                    <li>Les colonnes en gras sont obligatoires</li>
                    <li>Les colonnes sont séparées par des virgules (,)</li>
                    <li>Les rangées sont séparées par des nouvelles lignes</li>
                    <li>Des guillements anglais doubles (") peuvent être utilisés si des virgules ou des nouvelles lignes sont nécéssaires dans une donnée</li>
                    <li>Des barres obliques inversées (\\) peuvent être utilisées avant des virgules afin que celles-ci ne soient pas comptées comme des nouvelles colonnes.</li>
                    <li>Les sports doivent être entrés sans faute d'orthographe et les majuscules ne sont pas considérées</li>
                    <li>Les régions doivent être entrées avec leur nom court. Par exemple: Centre-du-Québec est CDQ</li>
                    <li>Aucune entête doit être fournie dans le fichier CSV, seulement les données</li>
                </ul>
                {{ link_to('/assets/exemple/creer-batch-participants.csv', 'Exemple de fichier') }}
            </div>
        </div>
        <div class="panel-body">
            <h2>Temporary</h2>
        </div>
    </div>
@stop
