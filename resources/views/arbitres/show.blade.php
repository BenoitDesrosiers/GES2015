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

		@if (count($arbitre->disponibiliteArbitre) < 1)
			<p>Disponibilités : Aucune disponibilité enregistrée</p>
		@else
			<p>Disponibilités :</p>
			<table class="tableArbitre">
				<thead>
				<tr>
					<th>Jour (AAAA-MM-JJ)</th>
					<th>Heure début</th>
					<th>Heure fin</th>
					<th>Commentaire</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($arbitre->disponibiliteArbitre as $dispo){
					echo "<tr><td class='dataDate'>".$dispo->date."</td><td class='dataDebut'>".$dispo->debut."</td><td class='dataFin'>".$dispo->fin."</td><td class='dataCommentaire'>".$dispo->commentaire."</td></tr>";}?>
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