@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $role->nom }}</h2>
	</div>
	<div class="panel-body">
		<p>Description: <?php echo $role->description ?></p>
	</div>
</div>
@stop