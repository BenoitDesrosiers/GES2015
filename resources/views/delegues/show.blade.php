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
							<a href="{!! action('RolesPourDeleguesController@show', $role->id) !!}">
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
		<!-- Inscrit tous les téléphones, s'il y en pas inscrit qu'il n'y en pas 	 -->
		<p>Telephone:</p>
		@if (count($delegue->telephones()->get()) > 0)

				@foreach ($delegue->telephones()->get() as $telephone)
					<p><?php echo $telephone->telephone ?></p>
				@endforeach

		@else
			<p>Le délégué n'a pas de téléphone</p>
		@endif
		<?php echo $delegue->courriel ?>
		<!-- Inscrit tous les courriels, s'il y en pas inscrit qu'il n'y en pas 	 -->
		<p>Courriel:</p>
		@if (count($delegue->courriels()->get()) > 0)

				@foreach ($delegue->courriels()->get() as $courriels)
					<p><?php echo $courriels->courriel ?></p>
				@endforeach

		@else
			<p>Le délégué n'a pas de courriel</p>
		@endif

	</div>
</div>
@stop