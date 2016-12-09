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
		
		<p>Numéro(s) de téléphone :</p>
		<table class="tableTelephoneCourrielArbitre">
			<thead>
				<tr>
					<th>Numéro</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($arbitre->arbitreTelephone as $telephone){echo "<tr><td class='dataTelephone'>".$telephone->numero_telephone."</td><td class='dataDescTelephone'>".$telephone->description."</td></tr>";}?>
			</tbody>
		</table>
		<br>
		
		@if (count($arbitre->arbitreCourriel) < 1)
			<p>Adresses courriel : Aucune adresse courriel enregistrée</p>
		@else
			<p>Adresses courriel :</p>
			<table class="tableTelephoneCourrielArbitre">
				<thead>
					<tr>
						<th>Courriel</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($arbitre->arbitreCourriel as $courriel){echo "<tr><td class='dataCourriel'>".$courriel->courriel."</td><td class='dataDescCourriel'>".$courriel->description."</td></tr>";}?>
				</tbody>
			</table>
			<br>
		@endif
		
		
		
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

   		@if (count($arbitre->sports) > 0)
   			<p>Sports: <ul> <?php foreach($arbitre->sports as $sport) { echo "<li>".$sport->nom."</li>"; } ?></ul></p>
   		@endif
	</div>
</div>
@stop