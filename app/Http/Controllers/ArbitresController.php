<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use App\Models\Arbitre;
use App\Models\Region;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Le contrôleur pour les arbitres
 * 
 * @author Sarah Laflamme
 * @version 0.0.1 rev 1
 */
class ArbitresController extends BaseController {

	/**
	 * Affiche une liste de tous les arbitres.
	 *
	 * @return Response
	 */
	public function index()
	{
		$arbitres = Arbitre::all();
		
		return View::make('arbitres.index', compact('arbitres'));
		
	}


	/**
	 * Affiche le formulaire de création d'un arbitre.
	 *
	 * @return Response
	 */
	public function create()
	{
		$regions = Region::all();

		return View::make('arbitres.create', compact('regions'));	
	}


	/**
	 * Enregistre dans la bd l'arbitre qui vient d'être créé.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		$arbitre = new Arbitre;
		$arbitre->prenom = $input['prenom'];
		$arbitre->nom = $input['nom'];
		$arbitre->region_id = $input['region_id'];
		$arbitre->numero_accreditation = $input['numero_accreditation'];
		$arbitre->association = $input['association'];
		$arbitre->numero_telephone = $input['numero_telephone'];
		$arbitre->adresse = $input['adresse'];
		$arbitre->sexe = $input['sexe'];
		$arbitre->date_naissance = $input['date_naissance'];
		
		if($arbitre->save()) {
			return Redirect::action('ArbitresController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($arbitre->validationMessages);
		}	
		
	}


	/**
	 * Affiche un seul arbitre.
	 *
	 * @param  int  $id l'id de l'arbitre à afficher
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$arbitre = Arbitre::findOrFail($id);
			$region = Region::findOrFail($arbitre->region_id);
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('arbitres.show', compact('arbitre', 'region'));
	}


	/**
	 * Affiche le formulaire pour éditer un arbitre.
	 *
	 * @param  int $id l'id de l'arbitre à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
		$arbitre = Arbitre::findOrFail($id);
		$regions = Region::all();
		return View::make('arbitres.edit', compact('arbitre', 'regions'));
	}


	/**
	 * Mise à jour de l'arbitre dans la bd.
	 *
	 * @param  int $id l'id de l'arbitre à changer.
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		$arbitre = Arbitre::findOrFail($id);
		$arbitre->prenom = $input['prenom'];
		$arbitre->nom = $input['nom'];
		$arbitre->region_id = $input['region_id'];
		$arbitre->numero_accreditation = $input['numero_accreditation'];
		$arbitre->association = $input['association'];
		$arbitre->numero_telephone = $input['numero_telephone'];
		$arbitre->adresse = $input['adresse'];
		$arbitre->sexe = $input['sexe'];
		$arbitre->date_naissance = $input['date_naissance'];
		
		if($arbitre->save()) {
			return Redirect::action('ArbitresController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($arbitre->validationMessages());
		}
	}


	/**
	 * Efface un arbitre de la bd.
	 *
	 * @param  int $id l'id de l'arbitre à effacer
	 * @return Response
	 */
	public function destroy($id)
	{
		$arbitre = Arbitre::findOrFail($id);
		$arbitre->delete();
		
		return Redirect::action('ArbitresController@index');
	
	}


}
