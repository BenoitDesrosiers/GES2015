@extends('layout')
@section('content')
	{{ Form::open(array('action' => array('sportParticipantController@store', $sport->id))) }}
	<div class="panel panel-default">
		<input name="sport" type="hidden" value="{{$sport->id}}">
		<div class="panel-heading">
			<h2>Liste des participants {{$sport->nom}}</h2>

			@if ($regions->isEmpty())
				<p>Il n'existe aucune région dans le système.</p>
			@else
				<select id="region" name="region">
					@foreach($regions as $region)
						@if (isset($region_id) && $region_id == $region->id)
							<option value="{{ $region->id }}" selected>{{ $region->nom }}</option>
						@else
							<option value="{{ $region->id }}">{{ $region->nom }}</option>
						@endif
					@endforeach
				</select>
				{{ Form::button('Sauvegarder', array('class' => 'btn btn-info', 'type' => 'submit')) }}
				<a href="{{ action('SportsController@index') }}" class="btn btn-warning">Retour</a>
				@foreach (['danger', 'warning', 'success', 'info'] as $msg)
					@if(Session::has('alert-' . $msg))
						<span class="text-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</span>
					@endif
				@endforeach
			@endif
		</div>

		<div id="listeParticipants">

		</div>
	</div>
	{{ Form::close() }}

@stop

@section('script')
	<script src="{{ asset('js/sportParticipant.js') }}"></script>
@stop