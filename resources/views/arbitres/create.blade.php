@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Création d'un arbitre</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> 'ArbitresController@index', 'class' => 'form']) !!}

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
			{!! Form::text('nom',null, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>

	<!--    Champ de texte pour le prénom -->
		<div class="form-group">
			{!! Form::label('prenom', '* Prénom :') !!} 
			{!! Form::text('prenom',null, ['class' => 'form-control']) !!}
			{{ $errors->first('prenom') }}
		</div>

	<!--    Liste déroulante pour la région -->
		<?php
			$regionArray = array();
			for ($i=0; $i<count($regions); $i++) {
				$regionArray[$i+1] = $regions[$i]['nom'];
			}
		?>
		<div class="form-group">
			{!! Form::label('region_id', '* Région :') !!} <br/>
			{!! Form::select('region_id', $regionArray) !!}
			{{ $errors->first('region_id') }}
		</div>

	<!--    Champ de texte pour le numéro d'accréditation -->
		<div class="form-group">
			{!! Form::label('numero_accreditation', '* Numéro d\'accréditation :') !!} 
			{!! Form::text('numero_accreditation',null, ['class' => 'form-control']) !!}
			{{ $errors->first('numero_accreditation') }}
		</div>

	<!--    Champ de texte pour l'association -->
		<div class="form-group">
			{!! Form::label('association', '* Association :') !!} 
			{!! Form::text('association',null, ['class' => 'form-control']) !!}
			{{ $errors->first('association') }}
		</div>

	<!--    Champ de texte pour le numéro de téléphone -->
		<div class="form-group">
			{!! Form::label('numero_telephone', '* Numéro de téléphone :') !!} 
			{!! Form::text('numero_telephone',null, ['class' => 'form-control']) !!}
			{{ $errors->first('numero_telephone') }}
		</div>

	<!--    Boutons radio pour le sexe -->
		<div class="form-group">
            {!! Form::label('sexe', '* Sexe :') !!}
            <br/>
            {!! Form::radio('sexe', 0, true) !!}
            {!! Form::label('homme', 'Homme') !!}
            <br/>
            {!! Form::radio('sexe', 1) !!}
            {!! Form::label('femme', 'Femme') !!}
            <br/>
            {{ $errors->first('sexe') }}
        </div>

	<!--    Champ de texte pour l'adresse -->
		<div class="form-group">
			{!! Form::label('adresse', 'Adresse :') !!} 
			{!! Form::text('adresse',null, ['class' => 'form-control']) !!}
			{{ $errors->first('adresse') }}
		</div>
        
	<!--    3 listes déroulantes pour la date -->
        <div class="form-group">
            {!! Form::label('naissance', '* Date de naissance :') !!}
            <br/>
            {!! Form::select('annee_naissance',$listeAnnees, $anneeDefaut,['style' => 'width:4em!important;']) !!}
            -
            {!! Form::select('mois_naissance',$listeMois, $moisDefaut, ['style' => 'width:3em!important;']) !!}
            -
            {!! Form::select('jour_naissance',$listeJours, $jourDefaut, ['style' => 'width:3em!important;']) !!}
            {{ $errors->first('naissance') }}
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
		
    <!--    Boutons Créer et Annuler -->		
		<div class="form-group">
			{!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>

	
		{!! Form::close() !!}
	</div>
</div>
@stop