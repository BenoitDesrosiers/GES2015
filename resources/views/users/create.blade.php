
@extends('layout')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Création d'un usager</h2>
        </div>
        <div class="panel-body">
        {!! Form::open(['action'=> 'UsagersController@index', 'class' => 'form', 'autocomplete' => 'off']) !!}

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

        <!--    Champ de texte pour le nom de l'usager -->
            <div class="form-group">
                {!! Form::label('nom', '* Nom :') !!}
                {!! Form::text('nom',"", ['class' => 'form-control']) !!}
                {{ $errors->first('name') }}
            </div>

            <!--    Champ de texte pour le courriel -->
            <div class="form-group">
                <!-- Ceci est un faux champs afin de contourner le auto-complete de Chrome. -->
                <input style="display:none" type="text" name="courriel"/>
                {!! Form::label('courriel', '* Courriel :') !!}
                {!! Form::text('courriel',"", ['class' => 'form-control']) !!}
                {{ $errors->first('courriel') }}
            </div>

            <!--    Champ de texte pour le mot de passe. -->
            <div class="form-group">
                <!-- Ceci est un faux champs afin de contourner le auto-complete de Chrome. -->
                <input style="display:none" type="password" name="mot_de_passe"/>
                {!! Form::label('mot_de_passe', 'Mot de passe:') !!}
                {!! Form::password('mot_de_passe', ['class' => 'form-control']) !!}
                {{ $errors->first('adresse') }}
            </div>

            <!-- Cette forme rassemble une liste des roles possible. -->
            <div class="form-group">
                {{ Form::label('roles', 'Roles:') }}
                @foreach($roles as $role)
                    <ul>
                        {{ Form::checkbox('role[]', $role->name) }}
                        {{ Form::label($role->display_name) }}
                    </ul>
                @endforeach

            </div>

            <!--    Boutons Creer et Annuler -->
            <div class="form-group">
                {!! Form::button('Creer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                <a href="{{ action('UsagersController@index') }}" class="btn btn-danger">Annuler</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop