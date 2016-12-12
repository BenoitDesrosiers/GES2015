
@extends('layout')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Modification du compte</h2>
        </div>
        <div class="panel-body">
        {!! Form::open(['action'=> array('UsagersController@updateCurrentUser', Auth::id()), 'method' => 'PUT', 'class' => 'form']) !!}

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
                {!! Form::text('nom',$usager->name, ['class' => 'form-control']) !!}
                {{ $errors->first('nom') }}
            </div>

            <!--    Champ de texte pour le prénom -->
            <div class="form-group">
                {!! Form::label('courriel', '* Courriel :') !!}
                {!! Form::text('courriel',$usager->email, ['class' => 'form-control']) !!}
                {{ $errors->first('courriel') }}
            </div>

            <!-- Champ de texte pour l'ancien mot de passe. -->
            <div class="form-group">
                <!-- Ceci est un faux champs afin de contourner le auto-complete de Chrome. -->
                <input style="display:none" type="password" name="old_mot_de_passe"/>
                {!! Form::label('old_mot_de_passe', 'Ancien mot de passe:') !!}
                {!! Form::password('old_mot_de_passe', ['class' => 'form-control']) !!}
                {{ $errors->first('old_mot_de_passe') }}
            </div>

            <!-- Champ de texte pour le nouveau mot de passe -->
            <div class="form-group">
                <!-- Ceci est un faux champs afin de contourner le auto-complete de Chrome. -->
                <input style="display:none" type="password" name="mot_de_passe"/>
                {!! Form::label('mot_de_passe', 'Nouveau mot de passe:') !!}
                {!! Form::password('mot_de_passe', ['class' => 'form-control']) !!}
                {{ $errors->first('mot_de_passe') }}
            </div>

            <!--    Boutons Sauvegarder et Annuler -->
            <div class="form-group">
                {!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                <a href="{{ action('HomeController@index') }}" class="btn btn-danger">Annuler</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop