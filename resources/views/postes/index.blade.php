@extends('layout')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Liste des postes</h2>
            <a href="{{ action('PostesController@create') }}" class="btn btn-info">Créer un poste</a>
        </div>
        @if ($postes->isEmpty())
            <div class="panel-body">
                <p>Aucun poste</p>
            </div>
        @else
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th class="hidden-xs">Description</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($postes as $poste)
                    <tr>
                        <td><a href="{{ action('PostesController@show', $poste->id) }}">{{ $poste->nom }}</a></td>
                        <td class="hidden-xs"><?php echo $poste->description ?></td>
                        <td><a href="{{ action('PostesController@edit',$poste->id) }}" class="btn btn-info">Modifier</a></td>
                        <td>{!! Form::open(array('action' => array('PostesController@destroy',$poste->id), 'method' => 'delete', 'data-confirm' => 'Êtes-vous certain?')) !!}
                            <button type="submit" href="{{ URL::route('postes.destroy', $poste->id) }}" class="btn btn-danger btn-mini">Effacer</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@stop