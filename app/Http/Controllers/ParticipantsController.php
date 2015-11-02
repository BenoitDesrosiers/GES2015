<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;
use App;

use App\Models\Participant;
use App\Models\Region;
use App\Models\Sport;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
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
		$routeActionName = 'ParticipantsController@index';
		$participants = Participant::all();
		$listeFiltres = ['Nom', 'Prénom', 'Numéro', 'Région', 'Équipe'];
		$valeurFiltre = 0;
		$valeurTexte = "";
		$infosTri = ParticipantsController::getInfosTri();
		$participants = ParticipantsController::trierColonnes($participants);
		
		return View::make('participants.index', compact('participants', 'routeActionName', 'infosTri', 'listeFiltres', 'valeurFiltre', 'valeurTexte'));	
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
	 * @param  int  $id. L'id du participant à afficher.
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
	 * @param  int $id. L'id du participant à éditer. 
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
	 * @param  int $id. L'id du participant à changer.
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
	 * @param  int $id. L'id du participant à effacer.
	 * @return Response
	 */
	public function destroy($id)
	{
		$participant = Participant::findOrFail($id);
		$participant->delete();
		
		return Redirect::action('ParticipantsController@index');
	
	}
	
	/**
	 * Recherche une entrée de la bd.
	 *
	 * @return Response
	 */
	public function recherche()
	{
		$routeActionName = 'ParticipantsController@index';
 		$listeFiltres = ['Nom', 'Prénom', 'Numéro', 'Région', 'Équipe'];
 		$infosTri = ParticipantsController::getInfosTri();
		$input = Input::all();
		$valeurFiltre = $input['listeFiltres'];
		$valeurTexte = $input['texteRecherche'];
		
		if ($valeurTexte != '') {
			if ($valeurFiltre == 0) {
				$participants = Participant::where('nom', 'like', $valeurTexte . '%')->get();
			} elseif ($valeurFiltre == 1) {
				$participants = Participant::where('prenom', 'like', $valeurTexte . '%')->get();			
			} elseif ($valeurFiltre == 2) {
				$participants = Participant::where('numero', $valeurTexte . '%')->get();	
			} elseif ($valeurFiltre == 3) {
				$region = Region::where('nom_court', 'like', $valeurTexte . '%')->first();
				if ($region) {
					$participants = $region->participants()->get();
				} else {
					$participants = new \Illuminate\Database\Eloquent\Collection;
				}
			} elseif ($valeurFiltre == 4) {
				$temporaire = $valeurTexte;
				if (is_string($valeurTexte)){
					if (strtolower($valeurTexte) == 'oui') {
						$valeurTexte = 1;
					} elseif (strtolower($valeurTexte) == 'non'){
						$valeurTexte = 0;
					}
				}
				$participants = Participant::where('equipe', 'like', $valeurTexte . '%')->get();
				$valeurTexte = $temporaire;
			} else {
				$participants = new \Illuminate\Database\Eloquent\Collection;
			}
		} else {
			$participants = Participant::all();
		}
		
		$participants = ParticipantsController::trierColonnes($participants);
		
		return View::make('participants.index', compact('participants', 'routeActionName', 'infosTri', 'listeFiltres', 'valeurFiltre', 'valeurTexte'));
	}
	
	/**
	 * Trie une collection.
	 *
	 * @param Collection $collectionNonTriee. Collection à trier selon le paramètre de tri et la direction.
	 * @return Collection $collectionTriee. Collection trier selon le paramètre de tri et la direction.
	 */
	public function trierColonnes($collectionNonTriee)
	{		
 		# Paramêtres récupérés dans le liens du titre de la colonne sélectionnée.
 		$parametreDeTri = Input::get('parametreDeTri');
		$direction = Input::get('direction');
 		
 		if ($direction == 'desc'){
			$collectionTriee = $collectionNonTriee->sortByDesc($parametreDeTri);
		} else {
			$collectionTriee = $collectionNonTriee->sortBy($parametreDeTri);
		}
		
		return $collectionTriee;
	}
	
	/**
	 * Retourne les informations de tri.
	 *
	 * @return Array $infosTri. Contient les informations de tri.
	 */
	public function getInfosTri(){
		$parametreDeTri = Input::get('parametreDeTri');
		$direction = Input::get('direction');
		$infosTri = [
				'nom' => [
						'texteAffiche'=>'Nom, Prenom',
						'trie'=>[
								'parametreDeTri'=>'nom',
								'direction'=>'asc']],
				'numero' => [
						'texteAffiche'=>'Numéro',
						'trie'=>[
								'parametreDeTri'=>'numero',
								'direction'=>'asc']],
				'region_id' => [
						'texteAffiche'=>'Région',
						'trie'=>[
								'parametreDeTri'=>'region_id',
								'direction'=>'asc']],
				'equipe' => [
						'texteAffiche'=>'Équipe',
						'trie'=>[
								'parametreDeTri'=>'equipe',
								'direction'=>'asc']]
		];
		
		if($parametreDeTri){
			if($direction == 'asc'){
				$infosTri[$parametreDeTri]['trie']['direction'] = 'desc';
			} else {
				$infosTri[$parametreDeTri]['trie']['direction'] = 'asc';
			}
		}
		
		return $infosTri;
	}
}
