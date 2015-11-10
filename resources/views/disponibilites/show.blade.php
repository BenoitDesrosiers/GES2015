@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title"><a href="{{ action('BenevolesController@show', $benevole->id) }}">Profil <- {{ $benevole->nom }}, {{ $benevole->prenom }}</a></h2>
	</div>
    
    <!--FullCalendar CSS & JavaScript habituellement dans le <head>.-->
    <link rel="stylesheet" href="{{ asset('/css/fullcalendar.css') }}"/>
    <script src="{{ asset('/js/moment.min.js') }}"></script>
    <script src="{{ asset('/js/fullcalendar.min.js') }}"></script>
	
    <div class="panel-body">
        {!! $calendrier->calendar() !!}
        {!! $calendrier->script() !!}
    </div>
</div>
@stop
