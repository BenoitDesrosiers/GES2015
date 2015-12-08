@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">{{ $code->nom }}</h2>
	</div>
	<div class="panel-body">
		<p>Description: <?php echo $code->description ?></p>
	</div>
</div>
@stop