<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use App\Models\Sport;
use App\Models\Terrain;

use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les sports
 * 
 * @author benou
 * @version 0.1
 */
class SportsController extends BaseController {

	/**
	 * Affiche une liste de ressource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			$sports = Sport::all();
			return View::make('sports.index', compact('sports'));
		} catch(Exception $e) {
			App::abort(404);
		}
		
		
	}

	/**
	 * Affiche le formulaire de création de la ressource.
	 *
	 * @return Response
	 */
	public function create()
	{
		try {
			$terrains = Terrain::all();
			return View::make('sports.create', compact('terrains'));
		} catch(Exception $e) {
			App::abort(404);
		}	
	}

	/**
	 * Enregistre dans la bd la ressource qui vient d'être créée.
	 *
	 * @return Response
	 */
	public function store()
	{
		try {
			$input = Input::all();
			if(isset($input['tournoi'])) {				
				$input['tournoi'] = '1';
			} else {
				$input['tournoi'] = '0';
			} 
			
			$sport = new Sport;
			$sport->nom = $input['nom'];
			$sport->saison = $input['saison'];
			$sport->description_courte = $input['description_courte'];
			$sport->url_logo = $input['url_logo'];
			$sport->url_page_officielle = $input['url_page_officielle'];
			$sport->tournoi = $input['tournoi'];
			
			if($sport->save()) {
				if (is_array(Input::get('terrain'))) {
	                    $sport->terrains()->attach(array_keys(Input::get('terrain')));
	                }
				return Redirect::action('SportsController@index')->with('status', 'Sport ajouté!');
			} else {
				return Redirect::back()->withInput()->withErrors($sport->validationMessages());
			}	
		} catch(Exception $e) {
			App::abort(404);
		}
	}

	/**
	 * Affiche la ressource.
	 *
	 * @param  int  $id l'id du sport à afficher
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$sport = Sport::findOrFail($id);
			$terrainSports = Sport::find($id)->terrains; //FIXME: pourquoi aller rechercher le sport une 2ième fois?
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('sports.show', compact('sport', 'terrainSports'));
	}

	/**
	 * Affiche le formulaire pour éditer la ressource.
	 *
	 * @param  int  $id l'id du sport à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
		try {
			$sport = Sport::findOrFail($id);
			$terrainSports = Sport::find($id)->terrains; //FIXME: on a déjà le sport
			$terrains = Terrain::all();

			return View::make('sports.edit', compact('sport', 'terrainSports', 'terrains'));
		} catch(Exception $e) {
			App::abort(404);
		}
	}

	/**
	 * Mise à jour de la ressource dans la bd.
	 *
	 * @param  int  $id l'id du sport à changer.
	 * @return Response
	 */
	public function update($id)
	{
		try { 
			$input = Input::all();
			if(isset($input['tournoi'])) {				
				$input['tournoi'] = '1';
			} else {
				$input['tournoi'] = '0';
			} 
			
			$sport = Sport::findOrFail($id);
			$sport->nom = $input['nom'];
			$sport->saison = $input['saison'];
			$sport->description_courte = $input['description_courte'];
			$sport->url_logo = $input['url_logo'];
			$sport->url_page_officielle = $input['url_page_officielle'];
			$sport->tournoi = $input['tournoi'];
			
			if($sport->save()) {
				if (is_array(Input::get('terrain'))) {
                    $sport->terrains()->sync(array_keys(Input::get('terrain')));
                } else {
                    $sport->terrains()->detach();
                }
				return Redirect::action('SportsController@index')->with('status', 'Sport mis à jour!');
			} else {
				return Redirect::back()->withInput()->withErrors($sport->validationMessages());
			}
		} catch(Exception $e) {
			App::abort(404);
		}
	}

	/**
	 * Efface la ressource de la bd.
	 *
	 * @param  int  $id l'id du sport à effacer
	 * @return Response
	 */
	public function destroy($id)
	{
		try {
			$sport = Sport::findOrFail($id);
			$sport->delete();
			
			return Redirect::action('SportsController@index');
		} catch(Exception $e) {
			App::abort(404);
		}
	}

}
