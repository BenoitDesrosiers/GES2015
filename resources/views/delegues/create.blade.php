@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Création d'un délégué</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> 'DeleguesController@index', 'class' => 'form']) !!}
		<!--    Affiche les messages d'erreur après un enregistrement raté -->
        @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
		<div class="form-group">
			{!! Form::label('nom', '*Nom:') !!}
			{!! Form::text('nom',null, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			{!! Form::label('prenom', '*Prénom:') !!}
			{!! Form::text('prenom',null, ['class' => 'form-control']) !!}
			{{ $errors->first('prenom') }}
		</div>
		<?php
            $regionArray = array();
            for ($i=0; $i<count($regions); $i++) {
            	$regionArray[$regions[$i]['id']]  = $regions[$i]['nom'];
            }
        ?>
		<div class="form-group">
            {!! Form::label('region_id', '*Région:') !!} <br/>
            {!! Form::select('region_id', $regionArray) !!}
            {{ $errors->first('region_id') }}
        </div>
		<div class="form-group">
            {!! Form::label('accreditation', '*Accréditation:') !!}
            <input type="checkbox" name="accreditation" >
            {{ $errors->first('accreditation') }}
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
			{!! Form::text('adresse',null, ['class' => 'form-control']) !!}
			{{ $errors->first('adresse') }}
		</div>
		<div class="form-group telephone">
			{!! Form::label('telephone', 'Téléphone:') !!}
			{!! Form::text('telephone[1]',null, ['class' => 'form-control telephone_texte' ]) !!}

			{{ $errors->first('telephone') }}
		</div>
			<button type = "button" id='add'>Ajouter un téléphone</button>
		<div class="form-group courriel">
			{!! Form::label('courriel', 'Courriel:') !!} 
			{!! Form::text('courriel',null, ['class' => 'form-control courriel_texte']) !!}
			{{ $errors->first('courriel') }}
		</div>
            <button type ="button" id='add2'>Ajouter un courriel</button>
		<!--    Lister tous les rôles possibles      -->
		<div class="form-group">
            {!! Form::label('roles', 'Rôles:') !!}
            @if (!$roles->isEmpty())
				@foreach ($roles as $role)
						<br/>
							<input name="role[{!! $role->id !!}]" type="checkbox" value="{!! $role->id !!}">
							{!! Form::label($role->nom) !!}
				@endforeach
			@else
				<p>Aucun rôle disponible.</p>
			@endif
		</div>
		<div class="form-group">
			{!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ action('DeleguesController@index') }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop
@section('script')
<script type="text/javascript">

	$(document).ready(function() {
        var removeButton = "<button type = 'button' onclick='remove1(this)'>Enlever ce téléphone</button>";
        $('#add').click(function () {
            var last_id = $('div.telephone').length;
            $('div.telephone:last').after($('div.telephone:first').clone());
            $('div.telephone:last input').attr('name', 'telephone[' + (last_id + 1) + ']');
            //$('div.telephone:last').setAttribute('nom','')
            $('div.telephone:last').append(removeButton);
            $('div.telephone:last input').each(function () {
                this.value = '';
            });
        });
    });

        function remove1(element) {
            var count = 1;
            $(element).closest('div.telephone').remove();
            $('div.telephone input').each(function () {
                this.name = 'telephone[' + count + ']';
                count = count + 1;
            })
        }



    $(document).ready(function() {

        var removeButton = "<button type = 'button' onclick='remove2(this)' class='remove2'>Enlever ce courriel</button>";
        $('#add2').click(function() {
            $('div.courriel:last').after($('div.courriel:first').clone())
            $('div.courriel:last').append(removeButton);
            $('div.courriel:last input').each(function () {
                this.value = '';
            });
        });
    });

    function remove2(element) {
        $(element).closest('div.courriel').remove();
    }



</script>


@stop