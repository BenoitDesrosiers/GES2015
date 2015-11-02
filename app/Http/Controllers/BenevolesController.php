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
		$benevoles = Benevole::all();
		
		return View::make('benevoles.index', compact('benevoles'));
		
	}


	/**
	 * Affiche le formulaire de création de la ressource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('benevoles.create');	
	}


	/**
	 * Enregistre dans la bd la ressource qui vient d'être créée.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		
		$benevole = new Benevole;
        $benevole->prenom = $input['prenom'];
		$benevole->nom = $input['nom'];
		$benevole->adresse = $input['adresse'];
		$benevole->numTel = $input['numTel'];
        $benevole->numCell = $input['numCell'];
        $benevole->courriel = $input['courriel'];
		$benevole->disponibilite = $input['disponibilite'];
		$benevole->accreditation = $input['accreditaiton'];
		$benevole->verification = $input['verification'];
		
		if($benevole->save()) {
			return Redirect::action('BenevolesController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($benevole->validationMessages());
		}	
	}


	/**
	 * Affiche la ressource.
	 *
	 * @param  int  $id l'id du bénévole à afficher
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$benevole = Benevole::findOrFail($id);
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('benevoles.show', compact('benevole'));
	}


	/**
	 * Affiche le formulaire pour éditer la ressource.
	 *
	 * @param  int  $id l'id du bénévole à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
		$benevole = Benevole::findOrFail($id);
		return View::make('benevoles.edit', compact('benevole'));
	}


	/**
	 * Mise à jour de la ressource dans la bd.
	 *
	 * @param  int  $id l'id du bénévole à changer.
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		
		$benevole = Benevole::findOrFail($id);
		$benevole->nom = $input['prenom'];
        $benevole->nom = $input['nom'];
		$benevole->adresse = $input['adresse'];
		$benevole->numTel = $input['numTel'];
        $benevole->numCell = $input['numCell'];
        $benevole->courriel = $input['courriel'];
		$benevole->disponibilite = $input['disponibilite'];
		$benevole->accreditation = $input['accreditaiton'];
		$benevole->verification = $input['verification'];
		
		if($benevole->save()) {
			return Redirect::action('BenevolesController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($benevole->validationMessages());
		}
	}


	/**
	 * Efface la ressource de la bd.
	 *
	 * @param  int  $id l'id du benevole à effacer
	 * @return Response
	 */
	public function destroy($id)
	{
		$benevole = Benevole::findOrFail($id);
		$benevole->delete();
		
		return Redirect::action('BenevolesController@index');
	
	}


}
