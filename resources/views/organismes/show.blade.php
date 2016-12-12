@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">Organisme: {{ $organisme->nomOrganisme }}</h2>
	</div>
	<div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {!! session('status') !!}
            </div>
        @endif
        @if ($organisme->telephone === NULL || $organisme->telephone === "")
			<p>Numéro de téléphone: Aucun</p>
		@else
			<p>Numéro de téléphone: {{ $organisme->telephone}}</p>
		@endif

		@if ($organisme->description === NULL || $organisme->description === "")
			<p>Description: Aucune description</p>
		@else
			<p>Description: {{ $organisme->description }}</p>
		@endif
	</div>
</div>
@stop