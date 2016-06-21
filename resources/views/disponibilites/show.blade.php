@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title"><a href="{{ action('BenevolesController@show', $benevole->id) }}">Profil <- {{ $benevole->nom }}, {{ $benevole->prenom }}</a></h2>
	</div>
    
    <!--FullCalendar JavaScript & CSS habituellement dans le <head>.-->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/moment.min.js') }}"></script>
    <script src="{{ asset('/js/fullcalendar.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/css/fullcalendar.min.css') }}"/>
	
    <div class="panel-body">
        {!! $calendrier->calendar() !!}
        {!! $calendrier->script() !!}
    </div>
</div>
@stop
