@extends('layout')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">{{ $terrain->nom }}</h2>
    </div>
    <div class="panel-body">
        <p>Région: {{ $region->nom }}</p>
        <p>Adresse: <?php if ($terrain->adresse == "") {echo "Aucune adresse";} else {echo $terrain->adresse;} ?></p>
        <p>Ville: <?php if ($terrain->ville == "") {echo "Aucune ville";} else {echo $terrain->ville;} ?></p>
        <p>Description: <?php if ($terrain->description_courte == "") {echo "Aucune description";} else {echo $terrain->description_courte;} ?></p>
    </div>
</div>
@stop