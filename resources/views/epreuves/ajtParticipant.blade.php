@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Ajouter un participant : {{$epreuve->nom}}</h2>
	</div>
	
    <table class="table table-striped table-hover">
        <tbody>

            {!! Form::open(array('action' => array('EpreuvesController@storeParticipants', $epreuve->id))) !!}
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

                <div>
                    <!-- Entête tableau -->
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>&nbsp;</th>
                            <th>Numéro</th>
                            <th>Participant</th>
                            <th>Région</th>
                        </tr>
                </div>
                    <div>
                    <!-- TODO: séparer les participants par régions, ou encore mieux, avoir un filtre de région -->
                    <tr>
                        @foreach ($participants as $participant)
                            <?php $checked = " "; ?>
                            <!-- FIXME: se servir des fonctions de collections: $listeIds = $epreuveParticipants->pluck('id'); ....  if($listeIds->contains($participant->id))... -->
                            @foreach ($epreuveParticipants as $epreuvePart)
                                @if ($epreuvePart->id == $participant->id)
                                    <?php $checked = " checked"; ?>
                                @endif
                            @endforeach
                        <?php $region = $participant->region; ?>
                    </tr>
                        <div>
                            <!-- Liste des participants -->
                            <th>
                                <input type="checkbox" name="participants[{{$participant->id}}]" <?=$checked?>>
                            </th>
                            <script>

                            </script>
                            <th>{{$participant->numero}}</th>
                            <th>{{$participant->nom}}, {{$participant->prenom}}</th>
                            <th>{{$region->nom}}</th>
                            <br/>
                            <!--
                            * if participant->region->id = regionid
                            *      if participant.isEmpty
                            *          print aucun participant
                            *      else
                            *          print participant
                            * elseif regionid = 0
                            *      print participant //tous les participants
                            -->
                        </div>
                        @endforeach
                    </table>
                </div>
            <div class="form-group">
                {!! Form::submit('Appliquer', array('class' => 'btn btn-primary')) !!}
                <a href="{{ action('EpreuvesController@index') }}" class="btn btn-danger">Annuler</a>
            </div>
                {!! Form::close() !!}
            {!! Form::close() !!}
        </tbody>
    </table>
    <script>
        var participants = {
            @foreach($participants as $participant)
                {{ $participant->id }}: {
                    numero: "{{ $participant->numero  }}",
                    nom:"{{ $participant->nom }}, {{ $participant->prenom }}",
                    participant_region_id:"{{ $participant->region->id }}",
                    region:"{{ $participant->region->nom }}"
                },
            @endforeach
        };
    </script>
    <script src="{!! asset('/js/trierParticipants.js') !!}">

    </script>
</div>
@stop