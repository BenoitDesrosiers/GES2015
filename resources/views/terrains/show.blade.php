@extends('layout')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">{{ $terrain->nom }}</h2>
    </div>
    <div class="panel-body">
        <p>Région: {{ $region->nom }}</p>
        <p>Adresse: {{ $terrain->adresse }}</p>
        <p>Ville: {{ $terrain->ville }}</p>
        <p>Description: {{ $terrain->description_courte }}</p>
        <p>Sports: <ul><?php foreach($terrainSports as $sport) { echo "<li>".$sport->nom."</li>"; } ?></ul></p>

    </div>
</div>
@stop