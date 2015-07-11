@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $sport->nom }}</h2>
	</div>
	<div class="panel-body">
		<p>Saison: <?php if ($sport->saison == "h") { echo "Hiver";} else {echo "Été";} ?></p>
		<p>Description: <?php if ($sport->description_courte == "") {echo "Aucune description";} else {echo $sport->description_courte;} ?></p>
		<p>Logo: <img src="{{ $sport->url_logo }}" alt="Logo du sport"/></p>
		<p>Page officielle: <a href="{{ $sport->url_page_officielle }}">Lien</a></p>
		<p>Tournoi: <?php if ($sport->tournoi == 1) {echo "Oui";} else {echo "Non";} ?></p>
	</div>
</div>
@stop