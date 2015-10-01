@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
        @if ($participant->equipe)
            <h2 class="panel-title">Équipe {{ $participant->nom }} {{ $participant->prenom }}</h2>
        @else
            <h2 class="panel-title">{{ $participant->nom }}, {{ $participant->prenom }}</h2>
        @endif
	</div>
	<div class="panel-body">
        @if (!$participant->equipe)
            <p>Genre:
                @if ($participant->sexe === 0)
                    M
                @elseif ($participant->sexe === 1)
                    F
                @else
                    Autre
                @endif
            </p>
            @if (!$participant->naissance === '0000-00-00')
                <p>Date de naissance: {!! $participant->naissance !!}</p>
            @endif
            @if ($participant->adresse)
                <p>Adresse: {!! $participant->adresse !!}</p>
            @endif
        @endif
        @if ($participant->telephone)
            <p>Numéro de téléphone: {!! $participant->telephone !!}</p>
        @endif
        @if ($participant->nom_parent)
            <p>Parent: {!! $participant->nom_parent !!}</p>
        @endif
		<p>Numéro: {{ $participant->numero }}</p>
        <p>Région: {{ $region->nom }}</p>
<!-- 		<p>Équipe: <?php if($participant->equipe) echo "Oui"; else echo "Non"; ?></p> -->
		<p>Sports: <ul><?php foreach($participantSports as $sport) { echo "<li>".$sport->nom."</li>"; } ?></ul></p>
	</div>
</div>
@stop