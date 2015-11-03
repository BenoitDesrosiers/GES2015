<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use App\Models\Benevole;


use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les bénévoles
 * 
 * @author dada
 * @version 0.1
 */
class BenevolesController extends BaseController {

	/**
	 * Affiche une liste de ressource.
	 *
	 * @return Response
	 */
	public function index()
	{
        try {
		    $benevoles = Benevole::all();
        
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('benevoles.index', compact('benevoles'));
		
	}


	/**
	 * Affiche le formulaire de création de la ressource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('disponibilites.create');	
	}


	/**
	 * Enregistre dans la bd la ressource qui vient d'être créée.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		
		$disponibilite = new Disponibilite;
        $disponibilite->commentaire = $input['commentaire'];
		$disponibilite->heure_debut = $input['heure_debut'];
		$disponibilite->heure_fin = $input['heure_fin'];
		
		if($disponibilite->save()) {
			return Redirect::action('DisponibilitesController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($disponibilite->validationMessages());
		}	
	}


	/**
	 * Affiche la ressource.
	 *
	 * @param  int  $id l'id du bénévole à afficher
	 * @return Response
	 *
	 * public function show($id)
	 * {
	 *	   try {
	 *		   $benevole = Benevole::findOrFail($id);
	 *	   } catch(ModelNotFoundException $e) {
	 *		   App::abort(404);
	 *	   }
	 *	   return View::make('benevoles.show', compact('benevole'));
	 * }
     */

	/**
	 * Affiche le formulaire pour éditer la ressource.
	 *
	 * @param  int  $id l'id du bénévole à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
        try{
		    $disponibilite = Disponibilite::findOrFail($id);
        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
		return View::make('disponibilites.edit', compact('disponibilite'));
	}


	/**
	 * Mise à jour de la ressource dans la bd.
	 *
	 * @param  int  $id l'id de la disponibilité à changer.
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		
		$disponibilite = Disponibilite::findOrFail($id);
		$disponibilite->commentaire = $input['commentaire'];
		$disponibilite->heure_debut = $input['heure_debut'];
		$disponibilite->heure_fin = $input['heure_fin'];
		
		if($disponibilite->save()) {
			return Redirect::action('DisponibilitesController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($diponibilite->validationMessages());
		}
	}


	/**
	 * Efface la ressource de la bd.
	 *
	 * @param  int  $id l'id de la disponibilité à effacer
	 * @return Response
	 */
	public function destroy($id)
	{
        try{
		    $disponibilite = Disponibilite::findOrFail($id);
		    $disponibilite->delete();
		 } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
		return Redirect::action('DisponibilitesController@index');
	
	}


}
