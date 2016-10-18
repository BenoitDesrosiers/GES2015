@extends('layout')
@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Liste des participants {{$sport->nom}}</h2>
			@if ($regions->isEmpty())
				<p>Il n'existe aucune région dans le système.</p>
			@else
				<div class="dropdown">
					<button class="btn btn-default dropdown-toggle" type="button" id="boutonDropDown" data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="true" name="dropdown">
						Choisir une région
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						@foreach($regions as $region)
							<li value="{{ $region->id }}"><a href="#">{{ $region->nom }}</a>
						@endforeach
					</ul>
				</div>
			@endif
		</div>

		<div id="listeParticipants">

		</div>
	</div>

@stop

@section('script')
	<script src="{{ asset('js/testing.js') }}"></script>
@stop