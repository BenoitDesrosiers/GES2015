@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title"><a href="{{ action('BenevolesController@index', $benevole->id) }}">Liste <- {{ $benevole->nom }}, {{ $benevole->prenom }}</a></h2>
	</div>
	<div class="panel-body">
		@if (session('status'))
            <div class="alert alert-success">
                {!! session('status') !!}
            </div>
        @endif
		<p>Adresse : {{ $benevole->adresse }}</p>
		<p>Numéro de Téléphone : {{ $benevole->numTel }}</p>
        <p>Numéro de Cellulaire : {{ $benevole->numCell }}</p>
        <p>Courriel : {{ $benevole->courriel }}</p>
		<p>Vérification : {{ $benevole->verification }}</p>
        <p>Sexe : {{ $benevole->sexe }}</p>
        <p>Date de naissance: {!! $benevole->naissance !!}</p>
        <p><a href="{{ action('DisponibilitesController@show',$benevole->id) }}" class="btn btn-info">Afficher Disponibilités</a></p>
        <p>Accréditation : {{ $benevole->accreditation }}</p>

        <p>Vérification : {{ $benevole->verification }}</p>
        
        <!--    Afficher les sports du bénévole      -->
		@if (!$benevole->sports->isEmpty())
			<p>Sports:</p>
			<ul>
				@foreach ($benevole->sports as $sport)
					<li>
						<a href="{!! action('SportsController@show', $sport->id) !!}">
							{!!$sport->nom!!}
						</a>
					</li>
				@endforeach
			</ul>
        @endif
        <!--    Afficher les terrains du benevole      -->
		@if (!$benevole->terrains->isEmpty())
			<p>Terrains:</p>
			<ul>
				@foreach ($benevole->terrains as $terrain)
					<li>
						<a href="{!! action('TerrainsController@show', $terrain->id) !!}">
							{!!$terrain->nom!!}
						</a>
					</li>
				@endforeach
			</ul>
        @endif

         <!--    Afficher les tâches du benevole      -->
		@if (!$benevole->taches->isEmpty())
			<p>Tâches:</p>
			<ul>
				@foreach ($benevole->taches as $tache)
					<li>
						<a href="{!! action('TachesController@show', $tache->id) !!}">
							{!!$tache->nom!!}
						</a>
					</li>
				@endforeach
			</ul>
        @endif


	</div>
</div>
@stop