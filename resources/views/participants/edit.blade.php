@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'un participant</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('ParticipantsController@update', $participant->id), 'method' => 'PUT', 'class' => 'form']) !!}
<!--    Affiche les messages d'erreur après un enregistrement raté -->
        @foreach ($errors as $error)
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
            {!! Form::label('equipe', 'Équipe:') !!}
            <input type="checkbox" name="equipe" @if ($participant->equipe) checked @endif >
            {{ $errors->first('equipe') }}
        </div>
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
            {!! Form::label('telephone', 'Numéro de téléphone:') !!} 
            {!! Form::text('telephone',$participant->telephone, ['class' => 'form-control']) !!}
            {{ $errors->first('telephone') }}
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
            {!! Form::radio('sexe', 0, $participant->sexe==false) !!}
            {!! Form::label('homme', 'Homme') !!}
            <br/>
            {!! Form::radio('sexe', 1, $participant->sexe==true) !!}
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
        <div class="form-group">
            {!! Form::label('adresse', 'Adresse:') !!} 
            {!! Form::text('adresse',$participant->adresse, ['class' => 'form-control']) !!}
            {{ $errors->first('adresse') }}
        </div>
		<?php
			$regionArray = array();
			for ($i=0; $i<count($regions); $i++) {
				$regionArray[$regions[$i]['id']] = $regions[$i]['nom'];
			}
		?>
		<div class="form-group">
			{!! Form::label('region_id', '*Région:') !!} <br/>
			{!! Form::select('region_id', $regionArray, $participant->region_id) !!}
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
@stop