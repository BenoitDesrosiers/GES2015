@if ($epreuves->isEmpty())
<div class="panel-body">
	<p>Aucune épreuve</p>
</div>
@else
<table id='latable' class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Nom</th>
			<th class="hidden-xs">Description</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
@foreach($epreuves as $epreuve)
		<tr>
			<td><a href="{{ action('EpreuvesController@show', [ $epreuve->id]) }}">{{$epreuve->nom }}</a></td>
			<td class="hidden-xs"><?php if ($epreuve->description == "") {echo "Aucune description";} else {echo $epreuve->description;} ?></td>
			<td><a href="{{ action('EpreuvesController@edit', [$epreuve->id]) }}" class="btn btn-info">Modifier</a></td>
			<td><a href="{{ action('EpreuvesController@ajtBenevole', [$epreuve->id]) }}" class="btn btn-info">Ajouter participant</a></td>
<!-- 			<td><a href="{{ action('EpreuvesController@ajtParticipant', [$epreuve->id]) }}" class="btn btn-info">Ajouter participant</a></td> -->
			<td><a href="{{ action('EpreuvesController@listeParticipant', [$epreuve->id]) }}" class="btn btn-info">Participants</a></td>
			<td>
				{!! Form::open(array('action' => array('EpreuvesController@destroy', $epreuve->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
				<button type="submit" href="{{ URL::route('epreuves.destroy', $epreuve->id) }}" class="btn btn-danger btn-mini">Effacer</button>
				{!! Form::close() !!} <?php  //FIXME: ca demande pas la confirmation??? ?>
			</td>
		</tr>
@endforeach
	</tbody>
</table>
@endif
