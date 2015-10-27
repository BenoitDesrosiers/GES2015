@extends('layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Modification d'un sport</h2>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=> array('SportsController@update', $sport->id), 'method' => 'PUT', 'class' => 'form']) !!}
		<div class="form-group">
			{!! Form::label('nom', 'Nom:') !!} 
			{!! Form::text('nom',$sport->nom, ['class' => 'form-control']) !!}
			{{ $errors->first('nom') }}
		</div>
		<div class="form-group">
			{!! Form::label('saison', 'Saison:') !!} 
			{!! Form::radio('saison','h', $sport->saison == 'h', ['id'=>'hiver', 'class' => 'radio-inline']) !!} Hiver
			{!! Form::radio('saison','e', $sport->saison == 'e', ['id'=>'ete', 'class' => 'radio-inline']) !!} Été
			{{ $errors->first('saison') }}				
		</div>
		<div class="form-group">
			{!! Form::label('description_courte', 'Description courte:') !!} 
			{!! Form::text('description_courte',$sport->description_courte, ['class' => 'form-control']) !!}
			{{ $errors->first('description_courte') }}				
		</div>
		<div class="form-group">
			{!! Form::label('url_logo', 'Url du logo:') !!} 
			{!! Form::text('url_logo',$sport->url_logo, ['class' => 'form-control']) !!}
			{{ $errors->first('url_logo') }}							
		</div>	
		<div class="form-group">
			{!! Form::label('url_page_officielle', 'Url de la page officielle:') !!} 
			{!! Form::text('url_page_officielle',$sport->url_page_officielle, ['class' => 'form-control']) !!}
			{{ $errors->first('url_page_officielle') }}								
		</div>	
		<div class="form-group">
			{!! Form::label('tournoi', 'Tournoi:') !!} 
			{!! Form::checkbox('tournoi',$sport->tournoi==true,$sport->tournoi==true) !!}
			{{ $errors->first('tournoi') }}				
		</div>
		<div class="form-group">
            {!! Form::label('terrains', 'Terrains:') !!} 
            <div class="row">
                <?php
                    foreach ($terrains as $terrain) {
                        $checked = "";
                        $active = "";
                        foreach ($terrainSports as $terrSport) {
                            if ($terrSport->id == $terrain->id) {
                                $checked = " checked";
                                $active = " active";
                                continue;
                            }
                        }
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 button-group" data-toggle="buttons">
                    <label class="btn btn-default btn-block<?=$active?>">
                        <input name="terrain[{{ $terrain->id }}]" type="checkbox"<?=$checked?>> {{ $terrain->nom }}
                    </label><br/>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>	
		<div class="form-group">
			{!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
			<a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@stop