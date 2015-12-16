@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'un délégué</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('DeleguesController@update', $delegue->id), 'method' => 'PUT', 'class' => 'form']) !!}
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
			{!! Form::text('nom',$delegue->nom, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			{!! Form::label('prenom', '*Prénom:') !!}
			{!! Form::text('prenom',$delegue->prenom, ['class' => 'form-control']) !!}
			{{ $errors->first('prenom') }}
		</div>
		<?php
			$regionArray = array();
			for ($i=0; $i<count($regions); $i++) {
				$regionArray[$regions[$i]['id']] = $regions[$i]['nom'];
			}
		?>
		<div class="form-group">
            {!! Form::label('region_id', '*Région:') !!} <br/>
			{!! Form::select('region_id', $regionArray, $delegue->region_id) !!}
            {{ $errors->first('region_id') }}
        </div>
		<div class="form-group">
            {!! Form::label('accreditation', '*Accréditation:') !!}
			<input type="checkbox" name="accreditation" @if ($delegue->accreditation) checked @endif >
            {{ $errors->first('accreditation') }}
        </div>
		<!--    Le sexe est entré via 2 boutons radio -->
        <div class="form-group">
            {!! Form::label('sexe', '*Genre:') !!}
            <br/>
            {!! Form::radio('sexe', 0, !$delegue->sexe) !!}
            {!! Form::label('homme', 'Homme') !!}
            <br/>
            {!! Form::radio('sexe', 1, $delegue->sexe) !!}
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
			{!! Form::text('adresse',$delegue->adresse, ['class' => 'form-control']) !!}
			{{ $errors->first('adresse') }}
		</div>
		<div class="form-group">
			{!! Form::label('telephone', 'Téléphone:') !!} 
			{!! Form::text('telephone',$delegue->telephone, ['class' => 'form-control']) !!}
			{{ $errors->first('telephone') }}
		</div>
		<div class="form-group">
			{!! Form::label('courriel', 'Courriel:') !!} 
			{!! Form::text('courriel',$delegue->courriel, ['class' => 'form-control']) !!}
			{{ $errors->first('courriel') }}
		</div>
		<!--    Lister tous les rôles possibles      -->
		<div class="form-group">
            {!! Form::label('roles', 'Rôles:') !!}
            @if (!$roles->isEmpty())
				@foreach ($roles as $role)
						<br/>
						@if (in_array($role->id, $postes))
							<!--	Précocher la case pour les rôles associés au délégué	 -->
							<input name="role[{!! $role->id !!}]" type="checkbox" value="{!! $role->id !!}" checked>
							<!-- 	Indiquer par un effet de couleur les rôles associés au délégué avant les modifications	 -->
							<mark>{!! Form::label($role->nom) !!}</mark>
						@else
							<input name="role[{!! $role->id !!}]" type="checkbox" value="{!! $role->id !!}">
							{!! Form::label($role->nom) !!}
						@endif
				@endforeach
			@else
				<p>Aucun role.</p>
			@endif
		</div>
		<div class="form-group">
			{!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop