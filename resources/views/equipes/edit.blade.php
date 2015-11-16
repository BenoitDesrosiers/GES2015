@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification de l'équipe {!! $chef->prenom !!} {!! $chef->nom !!}</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('EquipesController@update', $chef->id), 'method' => 'PUT', 'class' => 'form']) !!}
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
<!--    Lister tous les joueurs possibles      -->
        @foreach ($joueurs as $joueur)
			<?php $estMembre = in_array($joueur->id, $membres) ?>
			<div class="form-group">
				@if ($estMembre)
<!-- 				Précocher la case pour les joueurs qui sont déjà membres de l'équipe	 -->
					<input name="joueur[{{ $joueur->id }}]" type="checkbox" value="{!! $joueur->id !!}" checked>
<!-- 				Indiquer par un effet de couleur les membres qui faisaient partie de l'équipe avant les modifications	 -->
					<mark>{!! Form::label($joueur->nom.', '.$joueur->prenom) !!}</mark>
				@else
					<input name="joueur[{{ $joueur->id }}]" type="checkbox" value="{!! $joueur->id !!}">
					{!! Form::label($joueur->nom.', '.$joueur->prenom) !!}
				@endif
			</div>
		@endforeach
		<div class="form-group">
			{!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop