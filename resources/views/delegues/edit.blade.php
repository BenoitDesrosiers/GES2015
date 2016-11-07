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
		<div class="form-group telephone">
			{!! Form::label('telephone', 'Téléphone:') !!} 
			{!! Form::text('telephone',$delegue->telephone, ['class' => 'form-control']) !!}
			{{ $errors->first('telephone') }}
		</div>
			<button type = "button" id='add'>Ajouter un téléphone</button>
		<div class="form-group courriel">
			{!! Form::label('courriel', 'Courriel:') !!} 
			{!! Form::text('courriel',$delegue->courriel, ['class' => 'form-control']) !!}
			{{ $errors->first('courriel') }}
		</div>
			<button type ="button" id='add2'>Ajouter un courriel</button>
		<!--    Lister tous les rôles possibles      -->
		<div class="form-group">
            {!! Form::label('roles', 'Rôles:') !!}
            @if (!$roles->isEmpty())
				@foreach ($roles as $role)
						<br/>
						@if (in_array($role->id, $postes))
							<?php //FIXME ce code n'est pas DRY, mettre des paramètres pour afficher ou non le checked et le mark ?>
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
@section('script')
<script>

	/**
	 * Script actif en tout temps sur la page. Cette fonction est activée lors que le bouton d'ajout
	 * pour les téléphones (avec le id --> add) est appuyé et clone l'ajout d'une entrée de téléphone
	 */
	$(document).ready(function() {
		var removeButton = "<button type = 'button' onclick='remove1(this)'>Enlever ce téléphone</button>";
		$('#add').click(function () {
			var last_id = $('div.telephone').length;
			$('div.telephone:last').after($('div.telephone:first').clone());
			$('div.telephone:last input').attr('name', 'telephone[' + (last_id + 1) + ']');
			$('div.telephone:last').append(removeButton);
			$('div.telephone:last input').each(function () {
				this.value = '';
			});
		});
	});

	/**
	 * Fonction effacant la div .telephone la plus proche. Permet d'effacer une entrée de téléphone
	 * @param element --> le bouton ayant été appuyé.
	 */
	function remove1(element) {
		var count = 1;
		$(element).closest('div.telephone').remove();
		$('div.telephone input').each(function () {
			this.name = 'telephone[' + count + ']';
			count = count + 1;
		})
	}



	$(document).ready(function() {
		/**
		 * Script actif en tout temps sur la page. Cette fonction est activée lors que le bouton d'ajout
		 * pour les courriels (avec le id --> add2) est appuyé et clone l'ajout d'une entrée de courriel
		 */
		var removeButton = "<button type = 'button' onclick='remove2(this)' class='remove2'>Enlever ce courriel</button>";
		$('#add2').click(function() {
			var last_id = $('div.courriel').length;
			$('div.courriel:last').after($('div.courriel:first').clone())
			$('div.courriel:last input').attr('name', 'courriel[' + (last_id + 1) + ']');
			$('div.courriel:last').append(removeButton);
			$('div.courriel:last input').each(function () {
				this.value = '';
			});
		});
	});
	/**
	 * Fonction effacant la div .courriel la plus proche. Permet d'effacer une entrée de courriel
	 * @param element --> le bouton ayant été appuyé.
	 */
	function remove2(element) {
		var count =1;
		$(element).closest('div.courriel').remove();
		$('div.courriel input').each(function () {
			this.name = 'courriel[' + count + ']';
			count = count + 1;
		})
	}

</script>


@stop