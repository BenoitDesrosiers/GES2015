@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $delegue->nom }}, {{ $delegue->prenom }}</h2>
	</div>
	<div class="panel-body">
		<p>Région: {{ $region->nom }}</p>
		<!-- 	Afficher les rôles du délégué	 -->
        @if (!$delegue->roles->isEmpty())
			<p>Rôles:
				<ul>
					@foreach ($delegue->roles as $role)
						<li>
							<a href="{!! action('RolesController@show', $role->id) !!}">
								{!! $role->nom !!}
							</a>
						</li>
					@endforeach
				</ul>
			</p>
        @endif
		<p>Accréditation: <?php if($delegue->accreditation) echo "Oui"; else echo "Non"; ?></p>
		<p>Genre:
            @if (!$delegue->sexe)
                Masculin
            @else
                Féminin
            @endif
        </p>
		<p>Date de naissance: {!! $delegue->date_naissance !!}</p>
		<p>Adresse: <?php echo $delegue->adresse ?></p>
		<p>Telephone: <?php echo $delegue->telephone ?></p>
		<p>Courriel: <?php echo $delegue->courriel ?></p>
	</div>
</div>
@stop