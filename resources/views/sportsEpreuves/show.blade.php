@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $epreuve->nom }}</h2>
	</div>
	<div class="panel-body">
		<p>Description: <?php if ($epreuve->description == "") {echo "Aucune description";} else {echo $epreuve->description;} ?></p>
	</div>
</div>
@stop