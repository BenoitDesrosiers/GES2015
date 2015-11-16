@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
<!--    Plus naturel de mentionner au début que c'est une équipe -->
        @if ($participant->equipe)
            <h2 class="panel-title">Équipe {{ $participant->nom }} {{ $participant->prenom }}</h2>
        @else
            <h2 class="panel-title">{{ $participant->nom }}, {{ $participant->prenom }}</h2>
        @endif
	</div>
	<div class="panel-body">
<!--    Affiche un message de confirmation après un enregistrement réussi -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <p>Genre:
            @if ($participant->sexe)
                Masculin
            @else
                Féminin
            @endif
        </p>
		<p>Numéro: {{ $participant->numero }}</p>
<!--    Une équipe n'a pas réellement d'adresse et de date de naissance -->
        @if (!$participant->equipe)
            @if ($participant->naissance != '0000-00-00')
                <p>Date de naissance: {!! $participant->naissance !!}</p>
            @endif
            @if ($participant->adresse)
                <p>Adresse: {!! $participant->adresse !!}</p>
            @endif
        @endif
<!-- 	Afficher les membres de l'equipe	 -->
		@if (!$participant->membres->isEmpty())
			<p>Membres:</p>
			<ul>
			@foreach ($participant->membres as $membre)
				<li>
					<a href="{{ action('ParticipantsController@show', $membre->joueur_id) }}">
						{!!$membre->joueur->nom!!}, {!!$membre->joueur->prenom!!}
					</a>
				</li>
			@endforeach
			</ul>
			</table>
        @endif
<!-- 	Afficher les équipes dont le participant est membre	 -->
		@if (!$participant->equipes->isEmpty())
			<p>Équipes:</p>
			<ul>
			@foreach ($participant->equipes as $equipe)
				<li>
					<a href="{{ action('ParticipantsController@show', $equipe->chef_id) }}">
						{!!$equipe->chef->prenom!!} {!!$equipe->chef->nom!!}
					</a>
				</li>
			@endforeach
			</ul>
        @endif
        @if ($participant->telephone)
            <p>Numéro de téléphone: {!! $participant->telephone !!}</p>
        @endif
        @if ($participant->nom_parent)
            <p>Parent: {!! $participant->nom_parent !!}</p>
        @endif
        <p>Région: {{ $region->nom }}</p>
        <p>Sports: <ul><?php foreach($participantSports as $sport) { echo "<li>".$sport->nom."</li>"; } ?></ul></p>
	</div>
</div>
@stop