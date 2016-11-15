﻿@extends('layout')
@section('content')
@section('script')

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
                @foreach ($participants as $participant)
                    <?php $checked = " "; ?>
                    <!-- FIXME: se servir des fonctions de collections: $listeIds = $epreuveParticipants->pluck('id'); ....  if($listeIds->contains($participant->id))... -->
                    @foreach ($epreuveParticipants as $epreuvePart)
                        @if ($epreuvePart->id == $participant->id)
                            <?php $checked = " checked"; ?>
                        @endif
                    @endforeach
                <?php $region = $participant->region; ?>
                @endforeach
        </tbody>
    </table>
    <div class="form-group">
        {!! Form::submit('Appliquer', array('class' => 'btn btn-primary')) !!}
        <a href="{{ action('EpreuvesController@index') }}" class="btn btn-danger">Annuler</a>
    </div>
            {!! Form::close() !!}
        {!! Form::close() !!}
    <script>
        var participants = {
            @foreach($participants as $participant)
                {{ $participant->id }}: {
                    // Les variables commencent par des lettres de l'alphabet, car ils se classent par ordre alphabétique.
                    numero: "{{ $participant->numero  }}",
                    nom:"{{ $participant->nom }}, {{ $participant->prenom }}",
                    region:"{{ $participant->region->nom }}",
                    participant_region_id:"{{ $participant->region->id }}",
                    participant_id:"{{ $participant->id }}"
                },
            @endforeach
        };
    </script>
    <script src="{!! asset('/js/trierParticipants.js') !!}"></script>
</div>
@stop