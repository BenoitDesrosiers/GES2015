@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'un arbitre</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('ArbitresController@update', $arbitre->id), 'method' => 'PUT', 'class' => 'form']) !!}

		<!--    Affiche les messages d'erreur après un enregistrement raté -->
        @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
		<!--    Affiche un message de confirmation après un enregistrement réussi -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

		<!--    Champ de texte pour le nom de famille -->
		<div class="form-group">
			{!! Form::label('nom', '* Nom :') !!} 
			{!! Form::text('nom',$arbitre->nom, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>

		<!--    Champ de texte pour le prénom -->
		<div class="form-group">
			{!! Form::label('prenom', '* Prénom :') !!} 
			{!! Form::text('prenom',$arbitre->prenom, ['class' => 'form-control']) !!}
			{{ $errors->first('prenom') }}
		</div>

		<!--    Liste déroulante pour la région -->
		<?php
			$regionArray = array();
			for ($i=0; $i<count($regions); $i++) {
            	$regionArray[$regions[$i]['id']]  = $regions[$i]['nom'];
			}
		?>
		<div class="form-group">
			{!! Form::label('region_id', '* Région :') !!} <br/>
			{!! Form::select('region_id', $regionArray, $arbitre->region_id) !!}
			{{ $errors->first('region_id') }}
		</div>

		<!--    Champ de texte pour le numéro d'accréditation -->
		<div class="form-group">
			{!! Form::label('numero_accreditation', '* Numéro accréditation :') !!} 
			{!! Form::text('numero_accreditation',$arbitre->numero_accreditation, ['class' => 'form-control']) !!}
			{{ $errors->first('numero_accreditation') }}
		</div>

		<!--    Champ de texte pour l'association -->
		<div class="form-group">
			{!! Form::label('association', '* Association :') !!} 
			{!! Form::text('association',$arbitre->association, ['class' => 'form-control']) !!}
			{{ $errors->first('association') }}
		</div>

		<!--    Champ de texte pour le numéro de téléphone -->
		<div class="form-group">
			{!! Form::label('numero_telephone', '* Numéro de téléphone :') !!} 
			{!! Form::text('numero_telephone',$arbitre->numero_telephone, ['class' => 'form-control']) !!}
			{{ $errors->first('numero_telephone') }}
		</div>


		<!--    Tableau d'entrées pour les disponibilités -->
		<div class="form-group">
			{!! Form::label('disponibilites', 'Disponibilités :') !!}
			<br>
			<button id="ajoutDisponibilite" class="btn btn-info" type="button" onClick="ajouterDisponibilite()">Ajouter une disponibilité</button>
			<br>
			<table id="tableDisponibilite" class="tableArbitre">
				<thead>
				<tr>
					<th>Jour</th>
					<th>Mois</th>
					<th>Annee</th>
					<th>Heure début (HH:MM)</th>
					<th>Heure fin (HH:MM)</th>
					<th>Commentaire</th>
				</tr>
				</thead>
				<tbody >
				<?php
					$i = 1;
					foreach ($arbitre->disponibiliteArbitre as $disponibilite) {
						if($i == 1){
				?>
				<!-- La première rangée n'a pas de bouton pour la retirer-->
				<tr class="rowDisponibilite">
					<td class="dataJour">{!! Form::text('jour['.$i.']', substr($disponibilite->date,-2),['maxlength' => '2', 'class' => 'form-control']) !!}</td>
					<td class="dataMois">{!! Form::text('mois['.$i.']',substr($disponibilite->date,-5,2), ['maxlength' => '2', 'class' => 'form-control']) !!}</td>
					<td class="dataAnnee">{!! Form::text('annee['.$i.']',substr($disponibilite->date,0,4), ['maxlength' => '4', 'class' => 'form-control']) !!}</td>

					<td class="dataDebut">{!! Form::select('debut['.$i.']',$listeHeures, $listeIndexHeuresDebut[$i]) !!}</td>

					<td class="dataFin">{!! Form::select('fin['.$i.']',$listeHeures, $listeIndexHeuresFin[$i]) !!}</td>
					<td class="dataCommentaire">{!! Form::text('commentaire['.$i.']',$disponibilite->commentaire, ['class' => 'form-control']) !!}</td>
				</tr>
				<?php
					}else{
				?>
				<!-- Si n'est pas la première rangée, on rajoute le bouton pour enlever la rangée-->
				<tr class="rowDisponibilite">
					<td class="dataJour">{!! Form::text('jour['.$i.']', substr($disponibilite->date,-2),['maxlength' => '2', 'class' => 'form-control']) !!}</td>
					<td class="dataMois">{!! Form::text('mois['.$i.']',substr($disponibilite->date,-5,2), ['maxlength' => '2', 'class' => 'form-control']) !!}</td>
					<td class="dataAnnee">{!! Form::text('annee['.$i.']',substr($disponibilite->date,0,4), ['maxlength' => '4', 'class' => 'form-control']) !!}</td>

					<td class="dataDebut">{!! Form::select('debut['.$i.']',$listeHeures, $listeIndexHeuresDebut[$i]) !!}</td>

					<td class="dataFin">{!! Form::select('fin['.$i.']',$listeHeures, $listeIndexHeuresFin[$i]) !!}</td>
					<td class="dataCommentaire">{!! Form::text('commentaire['.$i.']',$disponibilite->commentaire, ['class' => 'form-control']) !!}</td>
					<td class="imageRetirer"><button class="btn btn-default btn-mini glyphicon glyphicon-minus"
													 type = "button" onclick="retirerDisponibilite(this)"></button></td>
				</tr>
				<?php
					}
					$i++;
					}
					if($i == 1){
				?>
				<!-- Si l'arbitre n'a aucune disponibilité, on affiche une rangée vide (pas rentré dans le foreach-->
				<tr class="rowDisponibilite">
					<td class="dataJour">{!! Form::text('jour['.$i.']', null,['maxlength' => '2', 'class' => 'form-control']) !!}</td>
					<td class="dataMois">{!! Form::text('mois['.$i.']',null, ['maxlength' => '2', 'class' => 'form-control']) !!}</td>
					<td class="dataAnnee">{!! Form::text('annee['.$i.']',null, ['maxlength' => '4', 'class' => 'form-control']) !!}</td>

					<td class="dataDebut">{!! Form::select('debut['.$i.']',$listeHeures, null) !!} </td>

					<td class="dataFin">{!! Form::select('fin['.$i.']',$listeHeures,null) !!}</td>
					<td class="dataCommentaire">{!! Form::text('commentaire['.$i.']',null, ['class' => 'form-control']) !!}</td>
				</tr>
				<?php
					}
				?>
				</tbody>
			</table>
			<br>
			{{ $errors->first('disponibilites') }}
		</div>
	</div>

		<!--    Boutons radio pour le sexe -->
        <div class="form-group">
            {!! Form::label('sexe', '* Sexe :') !!}
            <br/>
            {!! Form::radio('sexe', 0, $arbitre->sexe==false) !!}
            {!! Form::label('homme', 'Homme') !!}
            <br/>
            {!! Form::radio('sexe', 1, $arbitre->sexe==true) !!}
            {!! Form::label('femme', 'Femme') !!}
            <br/>
            {{ $errors->first('sexe') }}
        </div>

    	<!--    Champ de texte pour l'adresse -->		
		<div class="form-group">
			{!! Form::label('adresse', 'Adresse :') !!} 
			{!! Form::text('adresse',$arbitre->adresse, ['class' => 'form-control']) !!}
			{{ $errors->first('adresse') }}
		</div>

		<!--    3 listes déroulantes pour la date -->
        <div class="form-group">
            {!! Form::label('date_naissance', '* Date de naissance :') !!}
            <br/>
            {!! Form::select('annee_naissance',$listeAnnees, $anneeDefaut,['style' => 'width:4em!important;']) !!}
            -
            {!! Form::select('mois_naissance',$listeMois, $moisDefaut, ['style' => 'width:3em!important;']) !!}
            -
            {!! Form::select('jour_naissance',$listeJours, $jourDefaut, ['style' => 'width:3em!important;']) !!}
            {{ $errors->first('date_naissance') }}
        </div>

    	<!--   Boutons « checkbox » pour la liste des sports -->
    	<div class="form-group">
			{!! Form::label('sports', 'Sports:') !!} 
			<div class="row">
				<?php
					foreach ($sports as $sport) {
						$checked = "";
						$active = "";
						foreach ($arbitre->sports as $arbitreSport) {
							if ($arbitreSport->id == $sport->id) {
								$checked = " checked";
								$active = " active";
							}
						}
				?>
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 button-group" data-toggle="buttons">
			        <label class="btn btn-default btn-block<?=$active?>">
			            <input name="sport[{{ $sport->id }}]" type="checkbox"<?=$checked?>> {{ $sport->nom }}
			        </label><br/>
			    </div>
				<?php
					}
				?>
			</div>
		</div>
		
	<!--    Boutons Sauvegarder et Annuler -->
		<div class="form-group">
			{!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
<script src="{!! asset('/js/script_arbitres.js') !!}"></script>
@stop