@extends('layout')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Information sur le client</h2>
        </div>
        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {!! session('status') !!}
                </div>
            @endif
            <p>Nom : {{ $usager->name }}</p>
            <p>Courriel : {{ $usager->email }}</p>
                <div id="liste-roles">
                    <h4><strong>Liste de rôle:</strong></h4>
                    <lu>
                        @foreach($roles as $role)
                            <li> {{  $role->display_name }}</li>
                        @endforeach
                    </lu>
                </div>
        </div>
        <div class="panel-footer">
            <a href="{{ action('UsagersController@index') }}" class="btn btn-primary">Retour</a>
        </div>
    </div>
@stop