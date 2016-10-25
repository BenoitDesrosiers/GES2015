@extends('layout')
@section('content')
	{!! Form::open(['action'=> 'OrganismesController@index','class' => 'form']) !!}
		<div class="form-group">
            {!! Form::label('nomOrganisme', '* Nom organisme:') !!} 
            {!! Form::text('nomOrganisme', null, ['class' => 'form-control nomOrganismeBox']) !!}
            {!! $errors->first('nomOrganisme') !!}
        </div>
        <div class="form-group">
            {!! Form::label('telephone', 'Téléphone:') !!}
            </br>
            {!! Form::text('telephone', null, ['class' => 'form-control telephone']) !!}
            {!! $errors->first('telephone') !!}
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Description:') !!} 
            {!! Form::text('description', null, ['class' => 'form-control boiteDescription']) !!}
            {!! $errors->first('description') !!}
        </div>
        <div class="form-group">
            <p>*Champ obligatoire.</p>
            {!! Form::button('Confirmer', ['action'=> 'OrganismesController@store', 'type' => 'submit', 'class' => 'btn btn-primary']) !!}
            <a href="{{ URL::previous() }}" class="btn btn-danger">Annuler</a>
        </div>
	{!! Form::close() !!}

<style>
    .nomOrganismeBox {
        width:300px;
    }

	.telephone {
		width:120px;
		display:inline-block;
	}

	.boiteDescription {
		padding-bottom:7px;
		width:500px;
		height:34px;
	}
</style>

<script type="text/javascript">
function countChars(countfrom,displayto) {
  var len = document.getElementById(countfrom).value.length;
  document.getElementById(displayto).innerHTML = len;
}
</script>

@stop