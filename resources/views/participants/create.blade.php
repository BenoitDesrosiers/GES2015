@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Création d'un participant</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> 'ParticipantsController@index', 'class' => 'form']) !!}
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
        <div class="form-group">
            {!! Form::label('nom', '*Nom:') !!} 
            {!! Form::text('nom','', ['class' => 'form-control']) !!}
            {{ $errors->first('nom') }}
        </div>
        <div class="form-group">
            {!! Form::label('prenom', '*Prenom:') !!} 
            {!! Form::text('prenom', '', ['class' => 'form-control']) !!}
            {{ $errors->first('prenom') }}
        </div>
        <div class="form-group">
            {!! Form::label('telephone', 'Numéro de téléphone:') !!} 
            {!! Form::text('telephone','', ['class' => 'form-control']) !!}
            {{ $errors->first('telephone') }}
        </div>
        <div class="form-group">
            {!! Form::label('nom_parent', 'Nom d\'un parent:') !!} 
            {!! Form::text('nom_parent','', ['class' => 'form-control']) !!}
            {{ $errors->first('nom_parent') }}
        </div>
        <div class="form-group">
            {!! Form::label('numero', '*Numéro:') !!} 
            {!! Form::text('numero','', ['class' => 'form-control']) !!}
            {{ $errors->first('numero') }}
        </div>
        <div class="form-group">
            {!! Form::label('sexe', '*Genre:') !!}
            <br/>
            {!! Form::radio('sexe', 0, true) !!}
            {!! Form::label('homme', 'Homme') !!}
            <br/>
            {!! Form::radio('sexe', 1) !!}
            {!! Form::label('femme', 'Femme') !!}
            <br/>
            {{ $errors->first('sexe') }}
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
            {!! Form::label('adresse', 'Adresse:') !!} 
            {!! Form::text('adresse','', ['class' => 'form-control']) !!}
            {{ $errors->first('adresse') }}
        </div>
        <?php
            $regionArray = array();
            for ($i=0; $i<count($regions); $i++) {
                $regionArray[$i+1] = $regions[$i]['nom'];
            }
        ?>
        <div class="form-group">
            {!! Form::label('region_id', 'Région:') !!} <br/>
            {!! Form::select('region_id', $regionArray) !!}
            {{ $errors->first('region_id') }}
        </div>
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
			{!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop