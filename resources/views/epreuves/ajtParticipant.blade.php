@extends('layout')
@section('content')
@section('script')

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Ajouter un participant : {{$epreuve->nom}}</h2>
	</div>

    {!! Form::open(array('action' => array('EpreuvesController@storeParticipants', $epreuve->id))) !!}
    <table class="table table-striped table-hover">
        <tbody>
                <!-- Dropdown -->
                <?php $regionArray = ["Toutes les régions"]; ?>
                @foreach ($regions as $region)
                    <?php $regionArray[$region->id] = $region->nom; ?>
                @endforeach
                <div class="form-group">
                    {!! Form::label('region_id', 'Région:') !!} <br/>
                    {!! Form::select('region_id', $regionArray) !!}
                    {{ $errors->first('region_id') }}
                </div>
        </tbody>
    </table>
    <div class="form-group">
        {!! Form::submit('Appliquer', array('class' => 'btn btn-primary')) !!}
        <a href="{{ action('EpreuvesController@index') }}" class="btn btn-danger">Annuler</a>
    </div>
        {!! Form::close() !!}
    {!! Form::close() !!}

    <script>
        /**
         * Mets les informations de tous les participants dans une variable de
         * type javascript pour pouvoir les trier et les afficher selon la région choisie.
        */
        var participants = {
            @foreach($participants as $participant)
                <?php $checked = false; ?>
                @foreach($epreuveParticipants as $epreuvePart)
                    @if($epreuvePart->id == $participant->id)
                        <?php $checked = true; ?>
                    @endif
                @endforeach
                {{ $participant->id }}: {
                    numero: "{{ $participant->numero  }}",
                    nom:"{{ $participant->nom }}, {{ $participant->prenom }}",
                    region:"{{ $participant->region->nom }}",
                    participant_region_id:"{{ $participant->region->id }}",
                    participant_id:"{{ $participant->id }}",
                    is_checked: {!! $checked ? "true" : "false" !!}
                },
            @endforeach
        };
    </script>
    <script src="{!! asset('/js/trierParticipants.js') !!}"></script>
    <script>
        /**
         * Lance la fonction pour afficher tous les participants au chargement de la page.
         */
        $(document).ready(function () {
            listerParticipants(participants);
        });
    </script>
</div>
@stop