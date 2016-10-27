{{-----------------------------------------------------------------
| show.blade.php
| Description: Fichier d'affichage d'un participant
| Créé le: Avant automne 2016
| Modifié le: 161026
| Par: (Auteur précédent inconnu), Res260 (A2016)
-----------------------------------------------------------------}}
@extends('layout')
@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title">{!! $participant->nom !!}, {!! $participant->prenom !!}</h2>
		</div>
		<div class="panel-body">
	<!--    Affiche un message de confirmation après un enregistrement réussi -->
			@if (session('status'))
				<div class="alert alert-success">
					{!! session('status') !!}
				</div>
			@endif
			<p>Genre:
				@if (!$participant->sexe)
					Masculin
				@else
					Féminin
				@endif
			</p>
			<p>Région: {!! $participant->region->nom !!}</p>
			<p>Numéro: {!! $participant->numero !!}</p>
	<!--    Une équipe n'a pas réellement d'adresse et de date de naissance -->
			@if (!$participant->equipe)
				@if ($participant->naissance != '0000-00-00')
					<p>Date de naissance: {!! $participant->naissance !!}</p>
				@endif
			@endif
			@if ($participant->nom_parent)
				<p>Parent: {!! $participant->nom_parent !!}</p>
			@endif
			<p>Téléphones:</p>
			<ul>
				@if ($participant->telephones->count() > 0)
					@foreach ($participant->telephones as $telephone)
						<li>
							<strong>{!! $telephone->description != "" ? $telephone->description : "(pas de description)"  !!} :</strong> {!! $telephone->numero !!}
						</li>
					@endforeach
				@else
					<li>Le participant n'a pas de téléphone</li>
				@endif
			</ul>
	<!-- 	Afficher les équipes dont le participant est membre	 -->
			@if (!$participant->equipes->isEmpty())
				<p>Équipes:</p>
				<ul>
					@foreach ($participant->equipes as $equipe)
						<li>
							<a href="{!! action('EquipesController@show', $equipe->id) !!}">
								{!!$equipe->nom!!}
							</a>
						</li>
					@endforeach
				</ul>
			@endif
	<!--    Afficher les sports du participant      -->
			@if (!$participant->sports->isEmpty())
				<p>Sports:</p>
				<ul>
					@foreach ($participant->sports as $sport)
						<li>
							<a href="{!! action('SportsController@show', $sport->id) !!}">
								{!!$sport->nom!!}
							</a>
						</li>
					@endforeach
				</ul>
			@endif
			<?php //TODO: afficher les épreuves auxquels est inscrit ce participants. ?>
		</div>
	</div>
@endsection
