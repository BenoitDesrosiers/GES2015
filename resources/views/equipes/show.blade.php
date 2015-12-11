@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">Équipe {!! $equipe->nom !!}</h2>
	</div>
	<div class="panel-body">
<!--    Afficher un message de confirmation après un enregistrement réussi -->
        @if (session('status'))
            <div class="alert alert-success">
                {!! session('status') !!}
            </div>
        @endif
        <p>Région: {!! $equipe->region->nom !!}</p>
        <p>Genre:
            @if ($equipe->sexe)
                Féminin
            @else
                Masculin
            @endif
        </p>
		<p>Numéro: {!! $equipe->numero !!}</p>
<!-- 	Afficher les membres de l'equipe	 -->
        @if (!$equipe->membres->isEmpty())
			<p>Membres:
				<ul>
					@foreach ($equipe->membres as $membre)
						<li>
							<a href="{!! action('ParticipantsController@show', $membre->id) !!}">
								{!! $membre->nom !!}, {!! $membre->prenom !!}
							</a>
						</li>
					@endforeach
				</ul>
			</p>
        @endif
<!-- 	Afficher le(s) sport(s) de cette équipe -->
        @if (!$equipe->sports->isEmpty())
			<p>Sport:
				<ul>
					@foreach ($equipe->sports as $sport)
						<li>
							<a href="{!! action('SportsController@show', $sport->id) !!}">
								{!!$sport->nom!!}
							</a>
						</li>
					@endforeach
				</ul>
			</p>
        @endif
	</div>
</div>
@stop