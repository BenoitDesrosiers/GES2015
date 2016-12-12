<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\ConditionParticuliereRequest;
use App\Models\ConditionParticuliere;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Redirect;
use Throwable;
use View;

/**
 * Class ConsitionsParticulieresController
 *
 * Controlleur pour le CRUD des conditions particulières.
 *
 * @author Res260
 * @created_at 161120
 * @modified_at 161129
 * @package App\Http\Controllers
 */
class ConditionsParticulieresController extends Controller
{

	/**
	 * Instantie le controlleur pour les conditions particulières.
	 */
	public function __construct()
	{
		$this->middleware('formatterConditionsParticulieres',
			['only' => ['store', 'update']]);
	}

	/**
	 * Affiche la page d'index des conditions particulières.
	 *
	 * @return \Illuminate\Contracts\View\View La page d'index des conditions particulières.
	 */
	public function index() {
		return View::make('conditionsParticulieres.index',
			['conditionsParticulieres' => ConditionParticuliere::all()]);
	}

	/**
	 * Affiche la page de création d'une condition paritculière.
	 *
	 * @return \Illuminate\Contracts\View\View La page de création d'une
	 * 										   condition particulière.
	 */
	public function create() {
		return View::make('conditionsParticulieres.create');
	}

	/**
	 * Affiche la vue de mise à jour d'une condition particulière.
	 *
	 * @param int $id L'id de la condition particulière à modifier.
	 *
	 * @return \Illuminate\Contracts\View\View La vue de mise à jour
	 *                                         d'une condition particulière.
	 */
	public function edit($id) {
		try {
			return View::make('conditionsParticulieres.edit',
							  ['condition' => ConditionParticuliere::findOrFail($id)]);
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		return null;
	}

	/**
	 * Enregistre une nouvelle condition particulière dans la base de données.
	 *
	 * @param ConditionParticuliereRequest $request La requête http avec les
	 *                                              informations envoyées par
	 *                                              l'utilisateur.
	 *
	 * @return \Illuminate\Http\RedirectResponse Une redirection vers la page
	 *                                           d'affichage de la nouvelle
	 *                                           condition particulière.
	 */
	public function store(ConditionParticuliereRequest $request) {
		try {
			$condition = ConditionParticuliere::create($request->all());
		} catch (Exception $e) {
			App::abort(500);
		}
		return Redirect::to('/conditionsParticulieres/' . $condition->id)
			->with('message', 'La condition particulière a été créée avec succès!')
			->with('alert-class', 'alert-success');
	}

	/**
	 * Met a jour la condition particulière #$id.
	 *
	 * @param ConditionParticuliereRequest $request
	 * @param int                          $id
	 *
	 * @return \Illuminate\Http\RedirectResponse Une redirection
	 *                                           vers la page d'index.
	 */
	public function update(ConditionParticuliereRequest $request, $id) {
		try {
			$condition = ConditionParticuliere::findOrFail($id);
			$condition->update($request->all());
			$condition->save();
		} catch (Exception $e) {
			App::abort(500);
		}
		return Redirect::to('/conditionsParticulieres')
			->with('message', 'La condition particulière a été mise à jour avec succès!')
			->with('alert-class', 'alert-success');
	}


	/**
	 * Affiche les détails de la condition particulière.
	 *
	 * @param int $id L'id de la condition particulière à afficher.
	 *
	 * @return \Illuminate\Contracts\View\View La vue conditionsParticulieres.show.
	 */
	public function show($id) {
		try {
			return View::make('conditionsParticulieres.show',
				['condition' => ConditionParticuliere::findOrFail($id)]);
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
		return null;
	}


	/**
	 * Supprime une condition particulière de la BDD.
	 *
	 * @param int $id L'id de la condition particulière à supprimer.
	 *
	 * @return \Illuminate\Http\RedirectResponse Redirige vers la page d'index.
	 */
	public function destroy($id) {
		try {
			ConditionParticuliere::findOrFail($id)->delete();
		} catch (Throwable $t) {
			// POUR PHP 7 (BIENVENUE DANS LE FUTUR)
			App::abort(404);
		} catch (Exception $e) {
			// POUR PHP 5 (pour benou)
			App::abort(404);
		}

		return Redirect::action('ConditionsParticulieresController@index')
			->with('message', 'La condition particulière a bien été supprimée!');
	}


}
