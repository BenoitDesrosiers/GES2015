@extends('layout')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title">{{ $poste->nom }}</h2>
        </div>
        <div class="panel-body">
            <p>Description: <?php echo $poste->description ?></p>
        </div>
    </div>
@stop
