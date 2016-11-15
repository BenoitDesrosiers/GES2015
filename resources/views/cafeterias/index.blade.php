@extends('layout')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Liste des cafétérias</h2>
        <a href="{{ action('CafeteriasController@create') }}" class="btn btn-info">Créer une cafétéria</a>                       
    </div>
    @if ($cafeterias->isEmpty())
	    <div class="panel-body">
	        <p>Aucune cafétéria</p>
	    </div>
	@else
		
    @endif
</div>
@stop