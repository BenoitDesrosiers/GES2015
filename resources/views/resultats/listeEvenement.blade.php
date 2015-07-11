@if ($evenements->isEmpty())
<p>Aucune épreuve</p>
@else
<?php $evenementsListe = [];
$id = $evenements[0]->id;
foreach($evenements as $evenement) {
	$evenementsListe[$evenement->id] = $evenement->nom;
}?>
{!! Form::select('evenementsListe', $evenementsListe, $id, array('id' => 'evenementsListe', 'style' => 'width:100%;margin-bottom:10px;')) !!}
@endif