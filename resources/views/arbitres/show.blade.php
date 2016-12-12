@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $arbitre->nom }}, {{ $arbitre->prenom }}</h2>
	</div>
	<div class="panel-body">
		<p>Région : {{ $arbitre->region->nom }}</p>
		<p>Numéro d'accréditation : {{ $arbitre->numero_accreditation }}</p>
		<p>Association : {{ $arbitre->association }}</p>
		<p>Numéro de téléphone : {{ $arbitre->numero_telephone }}</p>
		<p>Sexe :
	        @if (!$arbitre->sexe)
	            Masculin
	        @else
	            Féminin
	        @endif
        </p>
        
		@if ($arbitre->adresse)
			<p>Adresse : {{ $arbitre->adresse }}</p>
		@endif

   		@if ($arbitre->date_naissance)
   			<p>Date de naissance : {{ $arbitre->date_naissance }}</p>
   		@endif

   		<!--  On liste les sports et les épreuves associés à l'arbitre -->
   		<p>Sports et leurs épreuves: <ul>
   		@if (count($arbitre->sports) > 0)
	   		@foreach ($arbitre->sports as $sport)
	   			@if (count($sport->epreuves) > 0)
	   				<li>{{ $sport->nom }}
	   					<ul>
							@foreach($sport->epreuves as $epreuve)						
								@if ($selectedEpreuves->contains($epreuve->id))
									<li>{{ $epreuve->nom }}</li>
								@endif				
							@endforeach
						</ul>
					</li>
				@endif	
			@endforeach
		@else
			<li>Aucun sport ni épreuve d'associé</li>
		@endif
			</ul>
		</p>
	</div>
</div>
@stop