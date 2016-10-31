@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'un bénévole</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('BenevolesController@update', $benevole->id), 'method' => 'PUT', 'class' => 'form'])!!}
        <!--    Affiche les messages d'erreur après un enregistrement raté -->
        @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
		<div class="form-group">
			{!! Form::label('nom', 'Nom :') !!} 
			{!! Form::text('nom', $benevole->nom, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
        <div class="form-group">
			{!! Form::label('prenom', 'Prénom :') !!} 
			{!! Form::text('prenom', $benevole->prenom, ['class' => 'form-control']) !!}
			{{ $errors->first('prenom') }}
		</div>
        <div class="form-group">
			{!! Form::label('adresse', 'Adresse :') !!} 
			{!! Form::text('adresse', $benevole->adresse, ['class' => 'form-control']) !!}
			{{ $errors->first('adresse') }}
		</div>
        <div class="form-group">
			{!! Form::label('numTel', 'Numéro de téléphone :') !!} 
			{!! Form::text('numTel', $benevole->numTel, ['class' => 'form-control']) !!}
			{{ $errors->first('numTel') }}
		</div>
        <div class="form-group">
			{!! Form::label('numCell', 'Numéro de cellulaire :') !!} 
			{!! Form::text('numCell', $benevole->numCell, ['class' => 'form-control']) !!}
			{{ $errors->first('numCell') }}
		</div>
        <div class="form-group">
			{!! Form::label('courriel', 'Courriel :') !!} 
			{!! Form::text('courriel', $benevole->courriel, ['class' => 'form-control']) !!}
			{{ $errors->first('courriel') }}
		</div>
        <div class="form-group">
			{!! Form::label('accreditation', 'Accréditation :') !!} 
			{!! Form::text('accreditation', $benevole->accreditation, ['class' => 'form-control']) !!}
			{{ $errors->first('accreditation') }}
		</div>

		<div class="form-group">
			{!! Form::label('sexe', 'Sexe :') !!} 
			{!! Form::select('sexe', ['M' => 'Masculin', 'F' => 'Féminin', 'A' => 'Autre'], $benevole->sexe); !!}
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
			{!! Form::label('verification', 'Vérification :') !!} 
			{!! Form::radio('verification','af', true, ['id'=>'afaire', 'class' => 'radio-inline']) !!} À faire
			{!! Form::radio('verification','ea', false, ['id'=>'enattente', 'class' => 'radio-inline']) !!} En attente
			{!! Form::radio('verification','f', false, ['id'=>'fait', 'class' => 'radio-inline']) !!} Fait
			{{ $errors->first('benevole') }}				
		</div>
		<div class="form-group">
			{!! Form::button('Modifier', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            <a href="{{ action('BenevolesController@show',$benevole->id) }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop
