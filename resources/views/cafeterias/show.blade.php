@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $cafeteria->nom }}</h2>
	</div>
	<div class="panel-body">
		<p>Adresse : {{ $cafeteria->adresse }}</p>
		<p>Localisation : {{ $cafeteria->localisation }}</p>
		<p>Responsable : </p>
		<ul>
			@foreach ($cafeteria->responsable as $responsable)
				<li>{{ $responsable->nom }} : {{ $responsable->telephone }}</li>
			@endforeach
		</ul>
	</div>
</div>
@stop