@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">Organisme: {{ $organisme->nomOrganisme }}</h2>
	</div>
	<div class="panel-body">
        @if (session()->has('success_create'))
			<div class="alert alert-success">
				{{ Session::get('success_create') }}
			</div>
		@endif

		@if (session()->has('success_update'))
			<div class="alert alert-success">
				{{ Session::get('success_update') }}
			</div>
		@endif

		@if (session()->has('success_delete'))
			<div class="alert alert-success">
				{{ Session::get('success_delete') }}
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

		<h3><u>Liste de contacts</u></h3>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>
						Prénom
					</th>
					<th>
						Nom
					</th>
					<th>
						# téléphone
					</th>
					<th>
						Rôle
					</th>
					<th class="col-xs-1 col-sm-1"/>
					<th class="col-xs-1 col-sm-1"/>
				</tr>
			</thead>
			@foreach($organisme->contacts as $contact)
				<tr>
					<td>
						{{ $contact->prenom }}
					</td>
					<td>
						{{ $contact->nom }}
					</td>
					<td>
						{{ $contact->telephone }}
					</td>
					<td>
						{{ $contact->role }}
					</td>
					<td>
						<a href="{{ action('ContactsController@edit', [$organisme->id, $contact->id]) }}" class="btn btn-info">Modifier</a>
					</td>
					<td>
						{{ Form::open(array('action' => array('ContactsController@destroy', $organisme->id, $contact->id), 'method' => 'delete', 'data-confirm' => 'Voulez-vous vraiment supprimer ce contact?')) }}
						<button type="submit" class="btn btn-danger btn-mini">Supprimer</button>
					{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</table>

		<div>
			<a href="{{ action('ContactsController@create', $organisme->id) }}" class="btn btn-info">Ajouter un contact</a>
		</div>
	</div>
</div>
@stop