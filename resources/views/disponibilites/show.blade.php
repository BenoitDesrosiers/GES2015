@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $benevole->nom }}, {{ $benevole->prenom }}</a></h2>
	</div>
	<div class="panel-body">
        {!! $calendrier->calendar() !!}
        {!! $calendrier->script() !!}
    </div>
</div>
@stop
