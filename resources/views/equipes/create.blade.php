@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Création d'une équipe</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> 'EquipesController@index', 'class' => 'form']) !!}
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
            {!! Form::text('nom','', ['class' => 'form-control']) !!}
            {{ $errors->first('nom') }}
        </div>
        <div class="form-group">
            {!! Form::label('numero', '*Numéro:') !!} 
            {!! Form::text('numero','', ['class' => 'form-control']) !!}
            {{ $errors->first('numero') }}
        </div>
        <?php
            $regionArray = array();
            for ($i=0; $i<count($regions); $i++) {
                $regionArray[$i+1] = $regions[$i]['nom'];
            }
        ?>
        <div class="form-group">
            {!! Form::label('region_id', 'Région:') !!}
            {!! Form::select('region_id', $regionArray) !!}
            {{ $errors->first('region_id') }}
        </div>
        <div class="form-group">
            {!! Form::label('sport', '*Sport:') !!}
            {{ $errors->first('sport') }}
            @foreach ($sports as $sport)
				<br/>
				{!! Form::radio('sport', $sport->id) !!}
				{!! Form::label('sport', $sport->nom) !!}
			@endforeach
        </div>

        <div class="form-group">
			{!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop