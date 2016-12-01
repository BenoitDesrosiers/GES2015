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
    <table class="table table-striped table-hover" id="liste_evenements">
        <thead>
            <tr>
        <!-- Titre des colonnes du tableau (s'adapte aux différentes dimensions selon les types de Bootstrap) -->
                <th>Nom</th>
                <th class="hidden-xs">Date</th>
                <th class="hidden-xs"><a v-on:click="toggleInverse"><em>Sport</em></a></th>
                <th class="hidden-xs">Type</th>
                <th class="col-sm-1"></th>
                <th class="col-sm-1"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="evenement in filteredData" :key="evenement.epreuve.sport.nom">
                <td>
                    <a :href="evenement.url_show">
                        @{{ evenement.nom }}
                    </a>
                </td>
                <td class="hidden-xs">
                    @{{ evenement.date_heure }}
                </td>
                <td class="hidden-xs">
                    @{{ evenement.epreuve.sport.nom }}
                </td>
                <td class="hidden-xs">
                    @{{ evenement.type.titre }}
                </td>
                <td>
                    <a :href="evenement.url_edit" class="btn btn-info">
                        Modifier
                    </a>
                </td>
                <td>
                    {!! Form::open(array(':action' => 'evenement.url_destroy', 'method' => 'delete', 'onsubmit' => 'return confirmDelete()')) !!}
                    <button type="submit" :href="evenement.url_destroy" class="btn btn-danger btn-mini confirm">
                        Effacer
                    </button>
                    {!! Form::close() !!}
                </td>
            </tr>
        </tbody>
    </table>
@endif
</div>
@stop

@push('scripts')
    <script src="{!! asset('js/vue.js') !!}"></script>
    <script src="{!! asset('js/evenements_index.js') !!}"></script>
@endpush
