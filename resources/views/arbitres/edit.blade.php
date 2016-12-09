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

		<!--    Tableau d'entrées pour les téléphones -->
		<div class="form-group">
			{!! Form::label('numero_telephone', '* Numéro(s) de téléphone :') !!}
			<br>
			<button id="ajoutTelephone" class="btn btn-info" type="button" onClick="ajouterTelephone()">Ajouter un téléphone</button>
			<br>
			<table id="tableTelephone" class="tableTelephoneCourrielArbitre">
				<thead>
				<tr>
					<th>Numéro</th>
					<th>Description</th>
				</tr>
				</thead>
				<tbody >
				<?php
					$i = 1;
					foreach ($arbitre->arbitreTelephone as $arbitreTelephone) {
						if($i == 1){
				?>
				<tr class="rowTelephone">
					<td class="dataTelephone">{!! Form::text('telephone['.$i.']',$arbitreTelephone->numero_telephone, ['class' => 'form-control' ]) !!}</td>
					<td class="dataDescTelephone">{!! Form::text('descriptionTelephone['.$i.']',$arbitreTelephone->description, ['class' => 'form-control']) !!}</td>
				</tr>
				<?php
					}else{
				?>
				<!-- Si n'est pas la première rangée, on rajoute le bouton pour enlever la rangée-->
				<tr class="rowTelephone">
					<td class="dataTelephone">{!! Form::text('telephone['.$i.']',$arbitreTelephone->numero_telephone, ['class' => 'form-control' ]) !!}</td>
					<td class="dataDescTelephone">{!! Form::text('descriptionTelephone['.$i.']',$arbitreTelephone->description, ['class' => 'form-control']) !!}</td>
					<td class="imageRetirer"><button class="btn btn-default btn-mini glyphicon glyphicon-minus"
						type = "button" onclick="retirerTelephone(this)"></button></td>
				</tr>
				<?php
					}
					$i++;
					}
				?>
				</tbody>
			</table>
			<br>
			{{ $errors->first('telephone') }}
			{{ $errors->first('descriptionTelephone') }}
		</div>

		<div class="form-group">
			{!! Form::label('adresse_courriel', 'Adresse(s) courriel :') !!}
			<br>
			<button id="ajoutCourriel" class="btn btn-info" type="button" onClick="ajouterCourriel()">Ajouter un courriel</button>
			<br>
			<table id="tableCourriel" class="tableTelephoneCourrielArbitre">
				<thead>
				<tr>
					<th>Courriel</th>
					<th>Description</th>
				</tr>
				</thead>
				<tbody >
				<?php
					$i = 1;
					foreach ($arbitre->arbitreCourriel as $arbitreCourriel) {
						if($i == 1){
				?>
				<!-- La première rangée n'a pas de bouton pour la retirer-->
				<tr class="rowCourriel">
					<td class="dataCourriel">{!! Form::text('courriel['.$i.']',$arbitreCourriel->courriel, ['class' => 'form-control' ]) !!}</td>
					<td class="dataDescCourriel">{!! Form::text('descriptionCourriel['.$i.']',$arbitreCourriel->description, ['class' => 'form-control']) !!}</td>
				</tr>
				<?php
					}else{
				?>
				<!-- Si n'est pas la première rangée, on rajoute le bouton pour enlever la rangée-->
				<tr class="rowCourriel">
					<td class="dataCourriel">{!! Form::text('courriel['.$i.']',$arbitreCourriel->courriel, ['class' => 'form-control' ]) !!}</td>
					<td class="dataDescCourriel">{!! Form::text('descriptionCourriel['.$i.']',$arbitreCourriel->description, ['class' => 'form-control']) !!}</td>
					<td class="imageRetirer"><button class="btn btn-default btn-mini glyphicon glyphicon-minus"
													 type = "button" onclick="retirerCourriel(this)"></button></td>
				</tr>
				<?php
					}
					$i++;
					}
					if($i == 1){
				?>
				<tr>
				<!-- Si l'arbitre n'a aucun courriel (on est pas entré dans le foreach), on crée un rangée vide-->
				<tr class="rowCourriel">
					<td class="dataCourriel">{!! Form::text('courriel['.$i.']',null, ['class' => 'form-control' ]) !!}</td>
					<td class="dataDescCourriel">{!! Form::text('descriptionCourriel['.$i.']',null, ['class' => 'form-control']) !!}</td>
				</tr>
				<?php
				}
				?>
				</tbody>
			</table>
			<br>
			{{ $errors->first('courriel') }}
			{{ $errors->first('descriptionCourriel') }}
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