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
        <!--
        	Copie de epreuves.edit afin d'implémenter la liste des arbitres
        	D'ici à la fin (70 - 128)
         -->
		<div class="form-group">
			<label>Arbitres: </label>
			<!-- Code original par "Dey-Dey" adapté pour le site -->
			<div class="container bootstrap snippet">
				<div class="row">
		      		<div class="col-sm-4 col-sm-offset-1">
		          		<div class="list-group" id="list1">
			          	<a class="list-group-item active"><span class="glyphicon glyphicon-user"></span>Arbitres Disponibles<input title="toggle all" type="checkbox" class="all pull-right"></a>
@foreach($arbitres as $arbitre)
						<a name="{{ $arbitre->id }}" class="list-group-item">{{ $arbitre->nom }}, {{ $arbitre->prenom }}<input type="checkbox" class="pull-right"></a>
@endforeach
			      		</div>
					</div>
						<div class="col-md-2 boutonTableEpreuve-center">
			     			<a title="Ajouter" class="btn btn-default center-block ajouter"><i class="glyphicon glyphicon-chevron-right"></i></a>
			        	    <a title="Retirer" class="btn btn-default center-block retirer"><i class="glyphicon glyphicon-chevron-left"></i></a>
						</div>
					<div class="col-sm-4">
		    		  	<div class="list-group" id="list2">
			  	        	<a class="list-group-item active"><span class="glyphicon glyphicon-user"></span>Arbitres attitrés<input title="toggle all" type="checkbox" class="all pull-right"></a>
 @foreach($arbitresSports as $arbitresSport) 
							<a name="{{ $arbitresSport->id }}" class="list-group-item">{{ $arbitresSport->nom }}, {{ $arbitresSport->prenom }}<input type="checkbox" class="pull-right"></a>  									   	
  @endforeach
		        	  	</div>
					<div>
						<input type="hidden" name="arbitresUtilises" id="arbitresUtilises"></input>
		      	  	</div>
					</div>
				</div>
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

@section('script')
	<script type="text/javascript">
		$('.ajouter').click(function(){
			transfererDroite();
			changer_liste();
		});

		$('.retirer').click(function(){
			transfererGauche();
			changer_liste();
		});
			
	</script>
	<script src="{{ asset('js/tableScript.js') }}"></script>
@stop

@section('stylesheet')
	<link rel="stylesheet" href="{{ asset('/css/tableCSS.css') }}">
@stop