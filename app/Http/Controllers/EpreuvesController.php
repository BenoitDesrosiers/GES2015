<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use App\Models\Sport;
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
		$sportId = Input::get('sportId');
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
		$sportId = $this->checkSportId($sports, $sportId);
		return View::make('epreuves.create', compact('sports', 'sportId'));
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
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		$sportId = $epreuve->sport->id;
		$sports = Sport::all();
		$sportId = $this->checkSportId($sports, $sportId);
		return View::make('epreuves.edit', compact('epreuve','sports', 'sportId'));
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
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('Epreuves.show', compact('epreuve'));
	}	
	
	/**
	 * Entrepose dans la bd une nouvelle épreuve qui sera associée à un sport
	 *
	 */
	public function store()
	{
		$input = Input::all();
		try {
			$sport = Sport::findOrFail($input["sportsListe"]);
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		$epreuve = new Epreuve;
		$epreuve->nom = $input['nom'];
		$epreuve->description = $input['description'];
		if($epreuve->save()) {
			try {
				//associe le sport aux épreuves (one to many)
				$epreuve = $sport->epreuves()->save($epreuve);
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
	{
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
	 * 
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

}
