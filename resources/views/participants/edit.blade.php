{{-----------------------------------------------------------------
| edit.blade.php
| Description: Vue d'édition d'un participant.
| Créé le: Avant automne 2016
| Modifié le: 161030
| Par: (Auteur précédent inconnu), Res260
-----------------------------------------------------------------}}
@extends('layout')
@section('content')
<link rel="stylesheet" href="{!! asset('/css/participants/create-edit.css') !!}">
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'un participant</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('ParticipantsController@update', $participant->id), 'method' => 'PUT', 'class' => 'form']) !!}
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
<!--    Les champs explicitement requis sont précédés d'un astérisque -->
		<div class="form-group">
			{!! Form::label('nom', '*Nom:') !!} 
			{!! Form::text('nom',$participant->nom, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			{!! Form::label('prenom', '*Prénom:') !!} 
			{!! Form::text('prenom',$participant->prenom, ['class' => 'form-control']) !!}
			{{ $errors->first('prenom') }}
		</div>
        <div class="form-group">
            {!! Form::label('nom_parent', 'Nom d\'un parent:') !!} 
            {!! Form::text('nom_parent',$participant->nom_parent, ['class' => 'form-control']) !!}
            {{ $errors->first('nom_parent') }}
        </div>
        <div class="form-group">
            {!! Form::label('numero', '*Numéro:') !!} 
            {!! Form::text('numero',$participant->numero, ['class' => 'form-control']) !!}
            {{ $errors->first('numero') }}
        </div>
<!--    Le sexe est entré via 2 boutons radio -->
        <div class="form-group">
            {!! Form::label('sexe', '*Genre:') !!}
            <br/>
            {!! Form::radio('sexe', 0, !$participant->sexe) !!}
            {!! Form::label('homme', 'Homme') !!}
            <br/>
            {!! Form::radio('sexe', 1, $participant->sexe) !!}
            {!! Form::label('femme', 'Femme') !!}
            <br/>
            {{ $errors->first('sexe') }}
        </div>
<!--    La date est entrée via 3 comboboxes -->
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
        <div id="conteneur-adresses">
            <?php $adresses = $participant->adresses()->orderBy('id')->get(); ?>
            @if(count($adresses) > 0)
                @foreach($adresses as $adresse)
                    <div class="form-group conteneur-adresse">
                        {!! Form::label('adresse-adresse-' . $adresse->id, 'Adresse:') !!}
                        {{ Form::text('adresse_adresse[]', $adresse->adresse, ['id' => 'adresse-adresse-' . $adresse->id, 'class' => 'form-control']) }}

                        {!! Form::label('adresse-description-' . $adresse->id, 'Description de l\'adresse:') !!}
                        {{ Form::text('adresse_description[]', $adresse->description, ['id' => 'adresse-description-' . $adresse->id, 'class' => 'form-control']) }}
                        <button onclick="retirerConteneur($(this).parent())" class="btn-danger" type="button" >Retirer</button>
                    </div>
                @endforeach
            @endif
        </div>
        <button onclick="ajouterAdresse()" id="bouton-ajouter-adresse" disabled class="btn-success" type="button">Ajouter une adresse</button>
		<div id="conteneur-telephones">
			<?php $telephones = $participant->telephones()->orderBy('id')->get(); ?>
			@if(count($telephones) > 0)
				@foreach($telephones as $telephone)
					<div class="form-group conteneur-telephone">
						{!! Form::label('telephone-numero-' . $telephone->id, 'Numéro de téléphone:') !!}
						{{ Form::text('telephone_numero[]', $telephone->numero,
						['id' => 'telephone-numero-' . $telephone->id, 'class' => 'form-control']) }}

						{!! Form::label('telephone-description-' . $telephone->id, 'Description du téléphone:') !!}
						{{ Form::text('telephone_description[]', $telephone->description,
						['id' => 'telephone-description-' . $telephone->id, 'class' => 'form-control']) }}
						<button onclick="retirerConteneur($(this).parent())" class="btn-danger" type="button" >Retirer</button>
					</div>
				@endforeach
			@else
				<div class="form-group conteneur-telephone">
					{!! Form::label('telephone-numero-1', 'Numéro de téléphone:') !!}
					{!! Form::text('telephone_numero[]', '',
                    ['id' => 'telephone-numero-1', 'class' => 'form-control']) !!}

					{!! Form::label('telephone-description-1', 'Description du téléphone:') !!}
					{!!  Form::text('telephone_description[]', '',
                    ['id' => 'telephone-description-1', 'class' => 'form-control']) !!}
				</div>
			@endif
		</div>
		<button onclick="ajouterTelephone()" id="bouton-ajouter-telephone" disabled class="btn-success" type="button">Ajouter un téléphone</button>

		<div class="form-group">
			<select name="region_id" id="region_id">
				@foreach ($regions as $region)
					<option value="{{ $region->id }}">{{$region->nom}}</option>
				@endforeach
			</select>
			{{ $errors->first('region_id') }}
		</div>
		<div class="form-group">
			{!! Form::label('sports', 'Sports:') !!} 
			<div class="row">
				<?php
					foreach ($sports as $sport) {
						$checked = "";
						$active = "";
						foreach ($participantSports as $partSport) {
							if ($partSport->id == $sport->id) {
								$checked = " checked";
								$active = " active";
								continue;
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
		<div class="form-group">
			{!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
<script src="{!! asset('/js/participants/gerer-infos-contact.js') !!}"></script>
@stop
