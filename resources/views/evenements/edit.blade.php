@extends('layout')
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('/css/dateHeure.css') }}">
@stop
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Modification d'une compétition</h2>
    </div>
    <div class="panel-body" id="vueEvenement">
        {!! Form::open(['action'=> array('EvenementsController@update', $evenement->id), 'method' => 'PUT', 'class' => 'form']) !!}
        @foreach ($errors->all() as $error)
        <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="form-group">
            {!! Form::label('nom', '* Nom:') !!} 
            {!! Form::text('nom', $evenement->nom, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group dateHeure">
            {!! Form::label('date', '* Date:') !!}
            {!! Form::date('date', $date, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group dateHeure">
            {!! Form::label('heure', '* Heure:') !!}
            {!! Form::time('heure', $heure, ['class' => 'form-control']) !!}
        </div>
        <?php
            $typeArray = array();
            for ($i=0; $i<count($types); $i++) {
                $typeArray[$types[$i]['id']]  = $types[$i]['titre'];
            }
        ?>
        <div class="form-group">
            {!! Form::label('type_id', '* Type:') !!} <br/>
            {!! Form::select('type_id', $typeArray, $evenement->type_id, ['class' => 'form-control largeurPetite']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('sport', '* Sport:') !!} <br/>
            <select v-model="sportSelectionne" class="form-control largeurPetite">
                <option v-for="sport in listeSports" v-bind:value="sport">
                    @{{ sport }}
                </option>
            </select>
        </div>
        <div class="form-group">
            {!! Form::label('epreuve_id', '* Épreuve:') !!} <br/>
            <select v-model="epreuveSelectionne" name="epreuve_id" class="form-control largeurPetite">
                <option v-for="option in listeEpreuves" v-bind:value="option.valeur">
                    @{{ option.texte }}
                </option>
            </select>
        </div>
        <div class="form-group">
            {!! Form::button('Sauvegarder', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            <a href="{{ action('EvenementsController@index') }}" class="btn btn-danger">Annuler</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

@push('scripts')
<script src="{!! asset('js/vue.js') !!}"></script>
<script src="{!! asset('js/evenements_create_edit.js') !!}"></script>
{{-- Changer la valeur par défaut des menu déroulants dans la Vue --}}
<script>
    vueEvenement.epreuveParDefaut = {{ $evenement->epreuve->id }};
</script>
@endpush
