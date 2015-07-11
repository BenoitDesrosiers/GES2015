@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $participant->nom }}, {{ $participant->prenom }}</h2>
	</div>
	<div class="panel-body">
		<p>Numéro: {{ $participant->numero }}</p>
		<p>Région: {{ $region->nom }}</p>
		<p>Équipe: <?php if($participant->equipe) echo "Oui"; else echo "Non"; ?></p>
		<p>Sports: <ul><?php foreach($participantSports as $sport) { echo "<li>".$sport->nom."</li>"; } ?></ul></p>
	</div>
</div>
@stop