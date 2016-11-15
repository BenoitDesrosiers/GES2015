<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use App\Models\Sport;
use App\Models\Epreuve;

use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * @brief Le controller pour les épreuves liées à un sport
 * @details Ce controller doit être appelé en lui passant l'id d'un sport
 * @version 0.1
 * @author benou
 */

class SportsEpreuvesController extends BaseController
{
	/**
	 * Affichage de toutes les épreuves reliées à un sport
	 * 
	 * @param[in] int $sportId l'id du sport auquel est associé l'épreuve
	 */
	public function index($sportId)
	{	
		
		try {
			$sport = Sport::findOrFail($sportId);
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		} catch (Exception $e) {
			return  View::make('erreurs.index')->with('e',$e);
		} 
		$epreuves = $sport->epreuves;
		return View::make('sportsEpreuves.index', compact('sport','epreuves')); 
	}
	
	/**
	 * Affiche le formulaire permettant de créer l'épreuve associée à un sport
	 * 
	 * @param[in] int $sportId l'id du sport auquel sera associé l'épreuve
	 */
	public function create($sportId)
	{
		try {
			$sport = Sport::findOrFail($sportId);
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('sportsEpreuves.create', compact('sport'));
	}
	
	/**
	 * Affiche le formulaire permettant d'éditer une épreuve associée à un sport
	 *
	 * @param[in] int $sportId l'id du sport auquel est associé l'épreuve
	 * @param[in] int $epreuveId l'id de l'épreuve 
	 */
	public function edit($sportId, $epreuveId)
	{
		try {
			$sport = Sport::findOrFail($sportId);
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		$epreuve = $sport->epreuves()->where('id', '=', $epreuveId)->first();
		return View::make('sportsEpreuves.edit', compact('sport', 'epreuve'));
	}
	
	/**
	 * Affiche une épreuve associée à un sport
	 *
	 * @param[in] int $sportId l'id du sport auquel est associé l'épreuve
	 * @param[in] int $epreuveId l'id de l'épreuve
	 */
	public function show($sportId, $epreuveId) 
	{
		try {
			$sport = Sport::findOrFail($sportId);
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		$epreuve = $sport->epreuves()->where('id', '=', $epreuveId)->first();
		return View::make('sportsEpreuves.show', compact('sport', 'epreuve'));
	}	
	
	/**
	 * Entrepose dans la bd une nouvelle épreuve qui sera associée à un sport
	 *
	 * @param[in] int $sportId l'id du sport auquel sera associé l'épreuve
	 */
	public function store($sportId)
	{
		try {
			$sport = Sport::findOrFail($sportId);
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		$input = Input::all();
		
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
			return Redirect::action('SportsEpreuvesController@index', $sportId);
		} else {
			return Redirect::back()->withInput()->withErrors($epreuve->validationMessages);
		}			
	}
	
	/**
	 * Mise à jour d'une épreuve associée à un sport
	 *
	 * @param[in] int $sportId l'id du sport auquel est associé l'épreuve
	 * @param[in] int $epreuveId l'id de l'épreuve
	 */
	public function update($sportId, $epreuveId)
	{
		try {
			$sport = Sport::findOrFail($sportId); //juste pour s'assurer que l'id de classe passé en paramêtre est valide, sinon: 404.
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		$input = Input::all();
				
		$epreuve = $sport->epreuves()->where('id', '=', $epreuveId)->first();
		$epreuve->nom = $input['nom'];
		$epreuve->description = $input['description'];
		$epreuve->sport_id = $sportId;
		if($epreuve->save()) { 
			return Redirect::action('SportsEpreuvesController@index', $sportId);
		} else {
			return Redirect::back()->withInput()->withErrors($epreuve->validationMessages);
		}
	}
	
	/**
	 * Efface une épreuve associée à un sport
	 *
	 * @param[in] int $sportId l'id du sport auquel est associé l'épreuve
	 * @param[in] int $epreuveId l'id de l'épreuve
	 */
	public function destroy($sportId, $epreuveId)
	{
		$epreuve = Epreuve::findOrFail($epreuveId);
		$epreuve->delete();
		
		return Redirect::action('SportsEpreuvesController@index', $sportId);
	}
	
	

	
	

}