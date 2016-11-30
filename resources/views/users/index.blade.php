@extends('layout')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Liste des usagers</h2>
            <a href="{{ action('UsagersController@create') }}" class="btn btn-info">Créer un usager</a>
        </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th class="hidden-xs">Roles</th>
                    <th class="hidden-sm hidden-xs">Courriel</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($usagers as $usager)
                    <tr>
                        <td><a href="{{ action('UsagersController@show', $usager->id) }}">{{ $usager->name }}</a></td>
                        <td>
                            <lu>
                                @foreach($usager->roles()->get() as $role)
                                    <li> {{  $role->display_name }}</li>
                                @endforeach
                            </lu>
                        </td>

                        @if(Auth::user()->getAttribute('name') == $usager->name)
                            <td title="Impossible de modifier l'utilisateur actuel.">
                                <button type="button" href="#" class="btn btn-info" disabled="disabled">Modifier</button>
                            </td>
                            <td title="Impossible de supprimer l'utilisateur actuel.">
                                <button type="button" href="#" class="btn btn-danger" disabled="disabled">Effacer</button>
                            </td>
                            {{-- Cette partie empêche l'usager connecté de modifier ou d'effacer son propre usager. --}}
                        @else
                            <td><a href="{{ action('UsagersController@edit',$usager->id) }}" class="btn btn-info">Modifier</a></td>
                            <td>{!! Form::open(array('action' => array('UsagersController@destroy',$usager->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
                                <button type="submit" href="{{ URL::route('users.destroy', $usager->id) }}" class="btn btn-danger btn-mini">Effacer</button>
                                {!! Form::close() !!}   {{-- méthode pour faire le delete tel que décrit sur http://www.codeforest.net/laravel-4-tutorial-part-2 ,
											un script js est appelé pour tous les form qui ont un "data-confirm" (voir assets/js/script.js) --}}
                            </td>
                        @endif

                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
@stop