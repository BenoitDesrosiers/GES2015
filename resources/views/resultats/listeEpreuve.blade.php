@if ($epreuves->isEmpty())
<p>Aucune épreuve</p>
@else
<?php $epreuvesListe = [];
$id = $epreuves[0]->id;
foreach($epreuves as $epreuve) {
	$epreuvesListe[$epreuve->id] = $epreuve->nom;
}?>
{!! Form::select('epreuvesListe', $epreuvesListe, $id, array('id' => 'epreuvesListe', 'style' => 'width:100%;margin-bottom:10px;')) !!}
@endif