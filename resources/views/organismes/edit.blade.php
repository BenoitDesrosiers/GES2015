@extends('layout')
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('/css/organismesCSS.css') }}">
@stop
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification de l'organisme: <span class="nomOrganismeModifie">{!! $organisme->nomOrganisme !!}</span></h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('OrganismesController@update', $organisme->id), 'method' => 'PUT', 'class' => 'form']) !!}

        @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="form-group">
            {!! Form::label('nomOrganisme', '*Nom organisme:') !!} 
            {!! Form::text('nomOrganisme',$organisme->nomOrganisme, ['class' => 'form-control nomOrganismeBoite']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('telephone', 'Téléphone:') !!}
            <br/>
            {!! Form::text('telephone',$organisme->telephone, ['class' => 'form-control telephone']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Description:') !!} 
            {!! Form::text('description',$organisme->description, ['class' => 'form-control boiteDescription']) !!}
        </div>
		<div class="form-group">
			{!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ action('OrganismesController@index') }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>

@stop