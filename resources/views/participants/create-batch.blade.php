@extends('layout')
@section('content')
    <link rel="stylesheet" href="{!! asset("/css/participants/create-batch.css") !!}">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Création de participants</h2>
            <div id="aide">
                Votre fichier CSV doit suivre les règles suivantes:
                <ul>
                    <li>Avoir au minimum le même nombre de colonnes que le tableau</li>
                    <li>Les sports auxquels les participants participent font partie des colonnes supplémentaires</li>
                    <li>Les colonnes soulignées sont obligatoires</li>
                    <li>Les colonnes sont séparées par des virgules (,)</li>
                    <li>Les rangées sont séparées par des nouvelles lignes</li>
                    <li>Des guillements anglais doubles (") peuvent être utilisés si des virgules ou des nouvelles lignes sont nécéssaires dans une donnée</li>
                    <li>Des barres obliques inversées (\) peuvent être utilisées avant des virgules afin que celles-ci ne soient pas comptées comme des nouvelles colonnes.</li>
                    <li>Les sports doivent être entrés sans faute d'orthographe et les majuscules ne sont pas considérées</li>
                    <li>Les régions doivent être entrées avec leur nom court. Par exemple: Centre-du-Québec est CDQ</li>
                    <li>Aucune entête doit être fournie dans le fichier CSV, seulement les données</li>
                    <li>Chaque rangée doit terminer avec une nouvelle ligne (\n). Sinon elle n'est pas utilisée</li>
                    <li>La date de naissance doit être écrite selon le format: JJ-MM-AAAA</li>
                    <li>Genre: 0 = Homme, 1 = Femme</li>
                </ul>
                {{ link_to('/assets/exemple/creer-batch-participants.csv', 'Exemple de fichier') }}
            </div>
        </div>
        <div class="panel-body">
            <div id="televersement" class="container-fluid">
                {{ Form::open(["action" => "ParticipantsController@createFromCSV", "class" => "form-horizontal", "method" => "POST", "files" => true]) }}
                <div class="row">
                    <div class="col-lg-3">
                        {{ Form::label("fichier-csv", "Envoyez votre fichier CSV:") }}
                    </div>
                    <div class="col-lg-4">
                        <input type="file" name="fichier-csv" id="fichier-csv">
                    </div>
                    <div class="col-lg-1">
                        {{ Form::submit("Envoyer", ["class" => "btn btn-info"]) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <br/>
            <div id="tableau">
                <table class="table table-bordered">
                    <tr>
                        <th>Erreur</th>
                        @foreach ($entetes as $entete => $obligatoire)
                            @if ($obligatoire[0] === true)
                                <th><u>{{ $entete }}</u></th>
                            @elseif ($loop->last)
                                <th {{ $rowspanEntete }}>{{ $entete }}</th>
                            @else
                                <th>{{ $entete }}</th>
                            @endif
                        @endforeach
                    </tr>
                    @if (!is_null($rangees))
                        @foreach ($rangees as $cle => $rangee)
                            @if (is_null($erreurs[$cle]))
                                <tr>
                            @else
                                <tr class="rangeeErronee">
                            @endif
                                <td>{{ $erreurs[$cle] }}</td>
                            @foreach ($rangee as $donnee)
                                <td>{{ utf8_encode($donnee) }}</td>
                            @endforeach
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
@stop
