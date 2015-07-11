@if ($resultat->isEmpty())
<div class="panel-body">
	<p>Aucun résultat</p>
</div>
@else
<div class="panel-body">
	<div class="text-center">
		<h4><?=date("Y-m-d H:i:s", time($resultat[0]->date_heure))?></h4>
	</div>
	<div class="row">
		<div class="col-md-6 text-center">
			<h3><a href="{{ action('ParticipantsController@show', $participant1->id) }}">{{ $participant1->prenom }} {{ $participant1->nom }}</a></h3>
			<?php if($resultat[0]->gagnant_id == $participant1->id) { ?>
			<h4>Gagnant!</h4>
			<?php } else { ?>
			<h4>Perdant</h4>
			<?php } ?>
			<br/>
			<h4>Résultat: <small><?=$resultat[0]->resultat1?></small></h4>
			<h4>Points: <small><?=$resultat[0]->points1?></small></h4>
		</div>
		<div class="col-md-6 text-center">
			<h3><a href="{{ action('ParticipantsController@show', $participant2->id) }}">{{ $participant2->prenom }} {{ $participant2->nom }}</a></h3>
			<?php if($resultat[0]->gagnant_id == $participant2->id) { ?>
			<h4>Gagnant!</h4>
			<?php } else { ?>
			<h4>Perdant</h4>
			<?php } ?>
			<br/>
			<h4>Résultat: <small><?=$resultat[0]->resultat2?></small></h4>
			<h4>Points: <small><?=$resultat[0]->points2?></small></h4>
		</div>
	</div>
</div>
@endif