@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Création d'un sport</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> 'SportsController@index', 'class' => 'form']) !!}
		<div class="form-group">
			{!! Form::label('nom', 'Nom:') !!} 
			{!! Form::text('nom',null, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			{!! Form::label('saison', 'Saison:') !!} 
			{!! Form::radio('saison','h', true, ['id'=>'hiver', 'class' => 'radio-inline']) !!} Hiver
			{!! Form::radio('saison','e', false, ['id'=>'ete', 'class' => 'radio-inline']) !!} Été
			{{ $errors->first('saison') }}				
		</div>
		<div class="form-group">
			{!! Form::label('description_courte', 'Description courte:') !!} 
			{!! Form::text('description_courte',null, ['class' => 'form-control']) !!}
			{{ $errors->first('description_courte') }}				
		</div>
		<div class="form-group">
			{!! Form::label('url_logo', 'Url du logo:') !!} 
			{!! Form::text('url_logo',null, ['class' => 'form-control']) !!}
			{{ $errors->first('url_logo') }}							
		</div>	
		<div class="form-group">
			{!! Form::label('url_page_officielle', 'Url de la page officielle:') !!} 
			{!! Form::text('url_page_officielle',null, ['class' => 'form-control']) !!}
			{{ $errors->first('url_page_officielle') }}				
		</div>	
		<div class="form-group">
			{!! Form::label('tournoi', 'Tournoi:') !!} 
			{!! Form::checkbox('tournoi',null, ['class' => 'form-control']) !!}
			{{ $errors->first('tournoi') }}
		</div>
		<div class="form-group">
            {!! Form::label('terrains', 'Terrains:') !!} 
            <div class="row">
                <?php
                    foreach ($terrains as $terrain) {
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 button-group" data-toggle="buttons">
                    <label class="btn btn-default btn-block">
                        <input name="terrain[{{ $terrain->id }}]" type="checkbox"> {{ $terrain->nom }}
                    </label><br/>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
		<div class="form-group">
			{!! Form::button('Créer', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop