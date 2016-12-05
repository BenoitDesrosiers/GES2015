{{-----------------------------------------------------------------
| create.blade.php
| Description: Vue de création d'un bénévole.
| Créé le: Avant automne 2016
| Modifié le: 161129
| Par: (Auteur précédent inconnu), Steve D.
-----------------------------------------------------------------}}
@extends('layout')
@section('content')
<link rel="stylesheet" href="{!! asset('/css/benevoles/create-edit.css') !!}">
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Création d'un bénévole</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> 'BenevolesController@index', 'class' => 'form']) !!}
        <!--    Affiche les messages d'erreur après un enregistrement raté -->
        @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
		<div class="form-group">
			{!! Form::label('nom', 'Nom :') !!} 
			{!! Form::text('nom',null, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
        <div class="form-group">
			{!! Form::label('prenom', 'Prénom :') !!} 
			{!! Form::text('prenom',null, ['class' => 'form-control']) !!}
			{{ $errors->first('prenom') }}
		</div>
        <div class="form-group">
			{!! Form::label('adresse', 'Adresse :') !!} 
			{!! Form::text('adresse',null, ['class' => 'form-control']) !!}
			{{ $errors->first('adresse') }}
		</div>
        <div class="form-group">
			{!! Form::label('numTel', 'Numéro de téléphone :') !!} 
			{!! Form::text('numTel',null, ['class' => 'form-control']) !!}
			{{ $errors->first('numTel') }}
		</div>
        <div class="form-group">
			{!! Form::label('numCell', 'Numéro de cellulaire :') !!} 
			{!! Form::text('numCell',null, ['class' => 'form-control']) !!}
			{{ $errors->first('numCell') }}
		</div>
        <div class="form-group">
			{!! Form::label('courriel', 'Courriel :') !!} 
			{!! Form::text('courriel',null, ['class' => 'form-control']) !!}
			{{ $errors->first('courriel') }}
		</div>
        <div class="form-group">
			{!! Form::label('accreditation', 'Accréditation :') !!} 
			{!! Form::text('accreditation',null, ['class' => 'form-control']) !!}
			{{ $errors->first('accreditation') }}
		</div>
		    <div class="form-group">
            {!! Form::label('naissance', '*Date de naissance:') !!}
            <br/>
            {!! Form::select('annee_naissance',$listeAnnees, $anneeDefaut,['style' => 'width:4em!important;']) !!}
            -
            {!! Form::select('mois_naissance',$listeMois, $moisDefaut, ['style' => 'width:3em!important;']) !!}
            -
            {!! Form::select('jour_naissance',$listeJours, $jourDefaut, ['style' => 'width:3em!important;']) !!}
            {{ $errors->first('naissance') }}
        </div>
		<div class="form-group">
			{!! Form::label('sexe', 'Sexe :') !!} 
			{!! Form::select('sexe', ['masculin' => 'Masculin', 'feminin' => 'Féminin', 'autre' => 'Autre']); !!}
			{{ $errors->first('sexe') }}
		</div>
        
        <div class="form-group">
			{!! Form::label('verification', 'Vérification :') !!} 
			{!! Form::radio('verification','af', true, ['id'=>'afaire', 'class' => 'radio-inline']) !!} À faire
			{!! Form::radio('verification','ea', false, ['id'=>'enattente', 'class' => 'radio-inline']) !!} En attente
			{!! Form::radio('verification','f', false, ['id'=>'fait', 'class' => 'radio-inline']) !!} Fait
			{{ $errors->first('benevole') }}				
		</div>
		
		<!--    Boutons « checkbox » pour les sports -->	
		<div class="form-group">
			{!! Form::label('sports', 'Sports:') !!} 
			<div class="row">
				<?php
					foreach ($sports as $sport) {
				?>
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 button-group" data-toggle="buttons">
			        <label class="btn btn-default btn-block">
			            <input name="sport[{{ $sport->id }}]" type="checkbox"> {{ $sport->nom }}
			        </label><br/>
			    </div>
				<?php
					}
				?>
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('terrains', 'Terrains:') !!} 
			<div class="row">
				<?php
					foreach ($terrains as $terrain) {
				?>
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 button-group" data-toggle="buttons">
			        <label class="btn btn-default btn-block">
			            <input name="terrain[{{ $terrain->id }}]" type="checkbox"> {{ $terrain->nom }}
			        </label><br/>
			    </div>
				<?php
					}
				?>
			</div>
		</div>
		
		{!! Form::label('disponibilites', 'Disponibilités:') !!} 
        <div id="conteneur-disponibilites">
            <div class="form-group conteneur-disponibilite">
                
                <label for="disponibilite_disponibilite[]">Description de la disponibilité:</label>
                <input type="text" name="disponibilite_disponibilite[]" id="disponibilite-disponibilite-1" class="form-control" maxlength="255" required/>
                	
				<label for="disponibilite_annee[]">Année:</label>
				<input type="number" name="disponibilite_annee[]" id="disponibilite-annee-1" class="form-control" step="1" min="2016" max="9999" required/>              	
                
                <label for="disponibilite_mois[]">Mois (en chiffre):</label>
				<input type="number" name="disponibilite_mois[]" id="disponibilite-mois-1" class="form-control" step="1" min="1" max="12" required/>
                
                <label for="disponibilite_jour[]">Jour:</label>
				<input type="number" name="disponibilite_jour[]" id="disponibilite-jour-1" class="form-control" step="1" min="1" max="31" required/>
                
                <label for="disponibilite_debut_heure[]">Heure de début:</label>
				<input type="number" name="disponibilite_debut_heure[]" id="disponibilite-debut-heure-1" class="form-control" step="1" min="0" max="23" required/>
                
                <label for="disponibilite_debut_minute[]">Minute de début:</label>
				<input type="number" name="disponibilite_debut_minute[]" id="disponibilite-debut-minute-1" class="form-control" step="1" min="0" max="59" required/>
                
                <label for="disponibilite_fin_heure[]">Heure de fin:</label>
				<input type="number" name="disponibilite_fin_heure[]" id="disponibilite-fin-heure-1" class="form-control" step="1" min="0" max="23" required/>
                
                <label for="disponibilite_fin_minute[]">Minute de fin:</label>
				<input type="number" name="disponibilite_fin_minute[]" id="disponibilite-fin-minute-1" class="form-control" step="1" min="0" max="59" required/>
            </div>
        </div>
        <div class="disponibilite-bouton">
        	<button onclick="ajouterDisponibilite()" id="bouton-ajouter-disponibilite" 
        		class="btn-success" type="button">Ajouter une disponibilité</button>
		</div>
		
		<div class="form-group">
			{!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ action('BenevolesController@index') }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
<script src="{!! asset('/js/benevoles/gerer-infos-disponibilites.js') !!}"></script>
@stop