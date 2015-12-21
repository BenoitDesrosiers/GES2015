<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use DB;
use App\Models\Sport;
use App\Models\Arbitre;
use App\Models\Epreuve;
use Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les épreuves liées à un sport
 *
 * 
 * @version 0.2
 * @author benou
 */

class EpreuvesController extends BaseController
{
	/**
	 * Affichage de toutes les épreuves
	 * 
	 * Si un sport est passé en paramètre, il sera choisi par défaut dans la liste
	 * 
	 * @param[in] get int sportId l'id du sport auquel est associé l'épreuve. 
	 * 					Une valeur absente ou 0 indique de prendre le premier sport de la liste.
	 */
	public function index()
	{	
		$sportId = Input::get('sportId'); //TODO: ajouter un try catch
		$sports = Sport::all();
		$sportId = $this->checkSportId($sports, $sportId);
		 
		return View::make('epreuves.index', compact('sports', 'sportId')); 
	}
	
	/**
	 * Affiche le formulaire permettant de créer une épreuve
	 * 
	 * @param[in] get int sportId l'id du sport auquel est associé l'épreuve. 
	 * 					Une valeur absente ou 0 indique de prendre le premier sport de la liste.
	 */
	public function create()
	{
		$sportId = Input::get('sportId');
		$sports = Sport::all();
		$arbitres = Arbitre::orderBy('nom', 'asc')->get(); //TODO: quand les arbitres seront associés à un sport, ne prendre que les arbitre du sport associé à l'épreuve
		$sportId = $this->checkSportId($sports, $sportId);
		return View::make('epreuves.create', compact('sports', 'sportId', 'arbitres', 'arbitresUtilises'));
	}
	
	/**
	 * Affiche le formulaire permettant d'éditer une épreuve 
	 *
	 * @param[in] int $epreuveId l'id de l'épreuve 
	 */
	public function edit($epreuveId)
	{
		try {
			$epreuve = Epreuve::findOrFail($epreuveId);
			$sportId = $epreuve->sport->id;
			$sports = Sport::all();
			$arbitresEpreuves = $epreuve->arbitre;
			$arbitres = EpreuvesController::filtrer_arbitres(Arbitre::orderBy('nom', 'asc')->get(), $arbitresEpreuves);
			//FIXME: au lieu d'avoir une fonction pour filtrer les arbitres déjà associés à une épreuve, on peut se servir du whereNotIn
			//       et fournir la liste des ids des arbitresEpreuves
			//       $arbitres = Arbitre::all()->whereNotIn('id', $arbitresEpreuves->pluck('id')) ->get();
			$sportId = $this->checkSportId($sports, $sportId);
			
			return View::make('epreuves.edit', compact('epreuve', 'sports', 'sportId', 'arbitres', 'arbitresEpreuves'));
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
	}
	
	/**
	 * Affiche une épreuve
	 *
	 * @param[in] int $epreuveId l'id de l'épreuve
	 */
	public function show($epreuveId) 
	{
		try {
			$epreuve = Epreuve::findOrFail($epreuveId);
			$arbitresEpreuves = $epreuve->arbitre;
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('Epreuves.show', compact('epreuve', 'arbitresEpreuves'));
	}	
	
	/**
	 * Entrepose dans la bd une nouvelle épreuve qui sera associée à un sport
	 *
	 */
	public function store()
	{ //FIXME: presque le même code que update, DRY
		$input = Input::all();
		try {
			$sport = Sport::findOrFail($input["sportsListe"]);
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		$epreuve = new Epreuve;
		$epreuve->nom = $input['nom'];
		$epreuve->description = $input['description'];
		$epreuve->sport_id = $input["sportsListe"];
		if($epreuve->save()) {
			try {
				$arbitresAEntrer = explode(",",Input::get('arbitresUtilises'));
				//Vérification qu'il y a bien un arbitre à entrer dans la BD.
                if (EpreuvesController::verifier_existence($arbitresAEntrer)) {
                    $epreuve->arbitre()->sync($arbitresAEntrer);
                } else {
                	$epreuve->arbitre()->detach();
            	}
			} catch (Exception $e) {
				App::abort(404);
			}
			return Redirect::action('EpreuvesController@index',array('sportId'=>$input["sportsListe"]));
		} else {
			return Redirect::back()->withInput()->withErrors($epreuve->validationMessages());
		}			
	}
	
	/**
	 * Mise à jour d'une épreuve associée
	 *
	 * @param[in] int $epreuveId l'id de l'épreuve
	 */
	public function update( $epreuveId)
	{  //FIXME: presque le même code que store, DRY
		$input = Input::all();
		try {
			$epreuve = Epreuve::findOrFail($epreuveId);
		} catch (Exception $e) {
			App::abort(404);
		}
		$epreuve->nom = $input['nom'];
		$epreuve->description = $input['description'];
		try {
			$sport = Sport::findOrFail($input["sportsListe"]);
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		$epreuve->sport_id = $sport->id;
		if($epreuve->save()) {
			$arbitresAEntrer = explode(",",Input::get('arbitresUtilises'));
			//Vérification qu'il y ai bien un arbitre à entrer dans la BD.
            if (EpreuvesController::verifier_existence($arbitresAEntrer)) {
                $epreuve->arbitre()->sync($arbitresAEntrer);
            } else {
                $epreuve->arbitre()->detach();
            } 
			return Redirect::action('EpreuvesController@index',array('sportId'=>$input["sportsListe"]));
		} else {
			return Redirect::back()->withInput()->withErrors($epreuve->validationMessages());
		}
	}
	
	/**
	 * Efface une épreuve associée à un sport
	 *
	 * @param[in] int $sportId l'id du sport auquel est associé l'épreuve
	 * @param[in] int $epreuveId l'id de l'épreuve
	 */
	public function destroy( $epreuveId)
	{
		$epreuve = Epreuve::findOrFail($epreuveId);
		$epreuve->delete();
		
		return Redirect::action('EpreuvesController@index');		
	}
	
	
	/**
	 * retourne la liste des epreuves pour un sport en format JSON
	 * 
	 * Doit être appelé par un call AJAX. 
	 * 
	 * @param[in] post int sportId l'id du sport pour lequel on veut lister les épreuves
	 * @return la sous-view pour afficher une liste d'épreuves.
	 */
	
	public function epreuvesPourSport() {
		if(Request::ajax()) {
			$sportId = Input::get('sportId');
			try {
				$sport = Sport::findOrFail($sportId); 
			} catch (ModelNotFoundException $e) {
				App::abort(404);
			}
			$epreuves = $sport->epreuves;
			return View::make('epreuves.listeEpreuve')->with('epreuves',$epreuves)->with('sport',$sport);

		} else {
			return App::abort(404);
		}
	}

	/**
	 * Verifie si un id de sport existe. Si oui:le retourne. Si non: retourne l'id du premier sport dans la liste
	 * 
	 * @param array $sports liste des sports. Utilisé si $sportId = 0 afin de choisir une valeur par défaut
	 * @param int $sportId un id de sport. Un sport avec cet id doit exister, sinon la le premier id de la liste sera utilisé
	 * @return int
	 */
	protected function checkSportId($sports, $sportId) {
		if($sportId <> 0) {
			//verifie que le sportid passé en paramêtre existe.
			try {
				$sport = Sport::findOrFail($sportId);
			} catch (Exception $e) {
				//si il n'existe pas, on prend celui du premier sport dans la liste
				$sportId = $sports[0]->id;
			}
		
		} else {
			//par default on prend le premier sport
			$sportId= $sports[0]->id;
		}
		return $sportId; 
	}
	
	/**
	 * Vérifie si les arbitres sont sous formes d'array etsi il y en as. 0 veut dire qu'il n'y a pas d'arbitres.
	 * @param $arbitres
	 * @return boolean
	 */
	protected function verifier_existence($arbitresAEntrer) {
		if (is_array($arbitresAEntrer) AND ($arbitresAEntrer[0] != "0")) {
			$retour = TRUE;  //FIXME: pourquoi ne pas juste retourner le résultat du IF?
		}else{
			$retour = FALSE;
		}
		return $retour;
	}
	
	/**
	 * filtre les arbitres pour retirer ceux déjà attribués à une épreuve.
	 * @param array $arbitres
	 * @param array $arbitresEpreuves
	 */
	protected function filtrer_arbitres($arbitres, $arbitresEpreuves){
		if ($arbitresEpreuves){
			foreach ($arbitres as $arbitre){
				foreach ($arbitresEpreuves as $index => $arbitreEpreuve) {
					if ($arbitreEpreuve->id == $arbitre->id) {
						$arbitres->pull($index);
					}
				}
			}
		}
		return $arbitres;
	}

}
