@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification de l'équipe {!! $equipe->prenom !!} {!! $equipe->nom !!}</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('EquipesController@update', $equipe->id), 'method' => 'PUT', 'class' => 'form']) !!}
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
            {!! Form::text('nom',$equipe->nom, ['class' => 'form-control']) !!}
            {{ $errors->first('nom') }}
        </div>
        <div class="form-group">
            {!! Form::label('numero', '*Numéro:') !!} 
            {!! Form::text('numero',$equipe->numero, ['class' => 'form-control']) !!}
            {{ $errors->first('numero') }}
        </div>
<!--    Lister tous les joueurs possibles      -->
		<div class="form-group">
            {!! Form::label('membres', 'Membres:') !!}
            @if (!$joueurs->isEmpty())
				@foreach ($joueurs as $joueur)
						<br/>
						@if (in_array($joueur->id, $membres))
<!-- 						Précocher la case pour les joueurs qui sont déjà membres de l'équipe	 -->
							<input name="joueur[{!! $joueur->id !!}]" type="checkbox" value="{!! $joueur->id !!}" checked>
<!-- 						Indiquer par un effet de couleur les membres qui faisaient partie de l'équipe avant les modifications	 -->
							<mark>{!! Form::label($joueur->nom.', '.$joueur->prenom) !!}</mark>
						@else
							<input name="joueur[{!! $joueur->id !!}]" type="checkbox" value="{!! $joueur->id !!}">
							{!! Form::label($joueur->nom.', '.$joueur->prenom) !!}
						@endif
				@endforeach
			@else
				<p>Aucun membre pour cette combinaison de sport et de région.</p>
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