<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use Resultat;
use Sport;
use Evenement;
use Participant;
use Epreuve;
use Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les résultats
 * 
 * @author BinarMorker
 * @version 0.0.1 rev 1
 */
class ResultatsController extends BaseController {

	/**
	 * Affiche un résultat.
	 *
	 * @return Response
	 */
	public function index()
	{
		$sportId = Input::get('sportId');
		$sports = Sport::all();
		$sportId = $this->checkSportId($sports, $sportId);
		$resultats = Resultat::all();
		
		return View::make('resultats.index', compact('sports', 'sportId', 'resultats'));
	}
	
	/**
	 * Retourne la liste des epreuves pour un sport en format JSON
	 * 
	 * Doit être appelé par un call AJAX. 
	 * 
	 * @param[in] post int sportId l'id du sport pour lequel on veut lister les épreuves
	 * @return la sous-view pour afficher une liste d'épreuves.
	 * 
	 */
	public function epreuvesPourSport() {
		if(Request::ajax()) {
			$sportId = Input::get('sportId');
			//$sportId = $this->checkSportId($sports, $sportId);
			try {
				$sport = Sport::findOrFail($sportId); 
			} catch (ModelNotFoundException $e) {
				App::abort(404);
			}
			$epreuves = $sport->epreuves;
			return View::make('resultats.listeEpreuve')->with('epreuves',$epreuves);

		} else {
			return App::abort(404);
		}
	}

	/**
	 * Retourne la liste des événements pour une épreuve en format JSON
	 *
	 * Doit être appelé par un call AJAX.
	 *
	 * @param[in] post int epreuveId l'id de l'épreuve pour laquelle on veut lister les événements
	 * @return la sous-view pour afficher une liste d'événements.
	 *
	 */
	public function evenementsPourEpreuve() {
		if(Request::ajax()) {
			$epreuveId = Input::get('epreuveId');
			//$epreuveId = $this->checkEpreuveId($epreuves, $epreuveId);
			try {
				$epreuve = Epreuve::findOrFail($epreuveId); 
			} catch (ModelNotFoundException $e) {
				App::abort(404);
			}
			$evenements = $epreuve->evenements;
			return View::make('resultats.listeEvenement')->with('evenements',$evenements);

		} else {
			return App::abort(404);
		}
	}

	/**
	 * Retourne le résultat pour un événement en format JSON
	 *
	 * Doit être appelé par un call AJAX.
	 *
	 * @param[in] post int evenementId l'id de l'événement pour lequel on veut montrer le résultat
	 * @return la sous-view pour afficher un résultat.
	 *
	 */
	public function resultatPourEvenement() {
		if(1==1 || Request::ajax()) {
			$evenementId = Input::get('evenementId');
			//$evenementId = $this->checkEvenementId($evenements, $evenementId);
			try {
				$evenement = Evenement::findOrFail($evenementId); 
				$resultats = $evenement->resultats;
				$resultat = Resultat::findOrFail($evenementId);
				$participant1 = Participant::findOrFail($resultat->participant1_id);
				$participant2 = Participant::findOrFail($resultat->participant2_id);
			} catch (ModelNotFoundException $e) {
				//App::abort(404);
				return View::make('resultats.resultat')->with('resultat',$resultats);
			}
			return View::make('resultats.resultat')->with('resultat',$resultats)->with('participant1',$participant1)->with('participant2',$participant2);

		} else {
			return App::abort(404);
		}
	}

	/**
	 * Vérifie si un identifiant de sport existe dans la BD.
	 *
	 * @param sports la liste de tous les sports
	 * @param sportId l'id du sport que l'on veut vérifier
	 * @return l'identifiant du sport s'il a été trouvé
	 *
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
	 * Vérifie si un identifiant d'épreuve existe dans la BD.
	 *
	 * @param epreuves la liste de toutes les épreuves
	 * @param epreuveId l'id de l'épreuve que l'on veut vérifier
	 * @return l'identifiant de l'épreuve si elle a été trouvée
	 *
	 */
	protected function checkEpreuveId($epreuves, $epreuveId) {
		if($epreuveId <> 0) {
			//verifie que le epreuveid passé en paramêtre existe.
			try {
				$epreuve = Epreuve::findOrFail($epreuveId);
			} catch (Exception $e) {
				//si il n'existe pas, on prend celui de la première epreuve dans la liste
				$epreuveId = $epreuves[0]->id;
			}
		
		} else {
			//par default on prend la première epreuve
			$epreuveId= $epreuves[0]->id;
		}
		return $epreuveId; 
	}

	/**
	 * Vérifie si un identifiant d'événement existe dans la BD.
	 *
	 * @param evenements la liste de tous les événements
	 * @param evenementId l'id de l'événement que l'on veut vérifier
	 * @return l'identifiant de l'événement s'il a été trouvé
	 *
	 */
	protected function checkEvenementId($evenements, $evenementId) {
		if($evenementId <> 0) {
			//verifie que le evenementid passé en paramêtre existe.
			try {
				$evenement = Evenement::findOrFail($evenementId);
			} catch (Exception $e) {
				//si il n'existe pas, on prend celui du premier evenement dans la liste
				$evenementId = $evenements[0]->id;
			}
	
		} else {
			//par default on prend le premier evenement
			$evenementId= $evenements[0]->id;
		}
		return $evenementId;
	}
	
}
