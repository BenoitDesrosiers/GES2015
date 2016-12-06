@extends('layout')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">{{ $evenement->nom }}</h2>
    </div>
    <div class="panel-body">
        <p>Type: {{ $evenement->type->titre }}</p>
        <p>Épreuve: {{ $evenement->epreuve->nom }}</p>
        <p>Date: {{ substr($evenement->date_heure, 0, 16) }}</p>
    </div>
</div>
@stop