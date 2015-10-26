<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use App\Models\Participant;
use App\Models\Region;
use App\Models\Sport;

use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les participants
 * 
 * @author BinarMorker
 * @version 0.0.1 rev 1
 */
class ParticipantsController extends BaseController {

	/**
	 * Affiche une liste de tous les participants.
	 *
	 * @return Response
	 */
	public function index()
	{
		# Paramêtres récupérés dans le liens du titre de la colonne sélectionnée.
		$parametreDeTri = Input::get('parametreDeTri');
		$direction = Input::get('direction');
		
		# Tableau qui possède toutes les informations nécessaire pour la gestion
		# des tris des colonnes.
		$colonnesTriees = [
		"colNom" => [
					"contrl"=>'ParticipantsController@index',
					"texteAffiche"=>'Nom, Prenom',
					"trie"=>[
						"parametreDeTri"=>'nom',
						"direction"=>'asc']],
		"colNum" => [
					"contrl"=>'ParticipantsController@index',
					"texteAffiche"=>'Numéro',
					"trie"=>[
						"parametreDeTri"=>'numero',
						"direction"=>'asc']],
		"colRegion" => [
					"contrl"=>'ParticipantsController@index',
					"texteAffiche"=>'Région',
					"trie"=>[
						"parametreDeTri"=>'region_id',
						"direction"=>'asc']],
		"colEquipe" => [
					"contrl"=>'ParticipantsController@index',
					"texteAffiche"=>'Équipe',
					"trie"=>[
						"parametreDeTri"=>'equipe',
						"direction"=>'asc']]
		];

		# Détermination de la colonne qui a été triée.
		if ($parametreDeTri == "numero") {
			$colonneChangee = "colNum";
		} elseif ($parametreDeTri == "region_id") {
			$colonneChangee = "colRegion";
		} elseif ($parametreDeTri == "equipe") {
			$colonneChangee = "colEquipe";
		} else {
			$parametreDeTri = "nom";
			$colonneChangee = "colNom";
		}
		
		# Changement de la direction pour la colonne qui a été triée.
		if ($direction == 'asc'){
			$prochaineDirection = 'desc';
		} else {
			$direction = 'desc';
			$prochaineDirection = 'asc';
		}
		
		# Si un tri est sélectionné, on lance la requête OrderBy, sinon on retourne
		# tous les participants.
		if ($parametreDeTri && $direction) {
			$participants = Participant::orderBy($parametreDeTri, $direction)->get();
		} else {
			$participants = Participant::get();
		}
		
		# Changement de la direction dans le liens qui va être créé par la View.
		$colonnesTriees[$colonneChangee]['trie']['direction'] = $prochaineDirection;
		
		return View::make('participants.index', compact('participants', 'colonnesTriees'));
		
	}


	/**
	 * Affiche le formulaire de création d'un participant.
	 *
	 * @return Response
	 */
	public function create()
	{
		$regions = Region::all();
		$sports = Sport::all();

		return View::make('participants.create', compact('regions', 'sports'));	
	}


	/**
	 * Enregistre dans la bd le participant qui vient d'être créé.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		if(isset($input['equipe'])) {				
			$input['equipe'] = '1';
		} else {
			$input['equipe'] = '0';
		} 

		$participant = new Participant;
		$participant->nom = $input['nom'];
		$participant->prenom = $input['prenom'];
		$participant->numero = $input['numero'];
		$participant->region_id = $input['region_id'];
		$participant->equipe = $input['equipe'];
		
		if($participant->save()) {
			if (is_array(Input::get('sport'))) { //Sauvegarde les sports associés au participant
				$participant->sports()->attach(array_keys(Input::get('sport')));
			}
			return Redirect::action('ParticipantsController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($participant->validationMessages());
		}	
		
	}


	/**
	 * Affiche un seul participant.
	 *
	 * @param  int  $id l'id du participant à afficher
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$participant = Participant::findOrFail($id);
			$region = Region::findOrFail($participant->region_id);
			$participantSports = Participant::find($id)->sports;
			$sports = Sport::all();
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('participants.show', compact('participant', 'region', 'sports', 'participantSports'));
	}


	/**
	 * Affiche le formulaire pour éditer un participant.
	 *
	 * @param  int $id l'id du participant à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
		$participant = Participant::findOrFail($id);
		$regions = Region::all();
		$participantSports = Participant::find($id)->sports;
		$sports = Sport::all();
		return View::make('participants.edit', compact('participant', 'regions', 'sports', 'participantSports'));
	}


	/**
	 * Mise à jour du participant dans la bd.
	 *
	 * @param  int $id l'id du participant à changer.
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		if(isset($input['equipe'])) {
			$input['equipe'] = '1';
		} else {
			$input['equipe'] = '0';
		}
		$participant = Participant::findOrFail($id);
		$participant->nom = $input['nom'];
		$participant->prenom = $input['prenom'];
		$participant->numero = $input['numero'];
		$participant->region_id = $input['region_id'];
		$participant->equipe = $input['equipe'];
		
		if($participant->save()) {
			if (is_array(Input::get('sport'))) {
				$participant->sports()->sync(array_keys(Input::get('sport')));
			} else {
				$participant->sports()->detach();
			}
			return Redirect::action('ParticipantsController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($participant->validationMessages());
		}
	}


	/**
	 * Efface un participant de la bd.
	 *
	 * @param  int $id l'id du participant à effacer
	 * @return Response
	 */
	public function destroy($id)
	{
		$participant = Participant::findOrFail($id);
		$participant->delete();
		
		return Redirect::action('ParticipantsController@index');
	
	}


}
