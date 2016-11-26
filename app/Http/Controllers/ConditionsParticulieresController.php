<?php

namespace App\Http\Controllers;

use App;
use App\Models\ConditionParticuliere;
use Exception;
use Illuminate\Http\Request;
use Redirect;
use Session;
use Throwable;
use View;

/**
 * Class ConsitionsParticulieresController
 *
 * Controlleur pour le CRUD des conditions particulières.
 *
 * @author Res260
 * @created_at 161020
 * @modified_at 161020
 * @package App\Http\Controllers
 */
class ConditionsParticulieresController extends Controller
{
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
	 * @return \Illuminate\Contracts\View\View La page de création d'une
	 * 										   condition particulière.
	 */
	public function create() {
		return View::make('conditionsParticulieres.create');
	}


	/**
	 * Affiche les détails de la condition particulière.
	 *
	 * @param $id int L'id de la condition particulière à afficher.
	 *
	 * @return \Illuminate\Contracts\View\View La vue conditionsParticulieres.show.
	 */
	public function show($id) {
		try {
			return View::make('conditionsParticulieres.show',
				['condition' => ConditionParticuliere::find($id)]);
		} catch (Throwable $t) {
			// POUR PHP 7 (BIENVENUE DANS LE FUTUR)
			App::abort(404);
		} catch (Exception $e) {
			// POUR PHP 5 (pour benou)
			App::abort(404);
		}
	}


	/**
	 * Supprime une condition particulière de la BDD.
	 *
	 * @param $id int L'id de la condition particulière à supprimer.
	 *
	 * @return \Illuminate\Http\RedirectResponse Redirige vers la page d'index.
	 */
	public function destroy($id) {
		try {
			ConditionParticuliere::findOrFail($id)->delete();
			Session::flash('message', 'La condition particulière a bien été supprimée!');
		} catch (Throwable $t) {
			// POUR PHP 7 (BIENVENUE DANS LE FUTUR)
			App::abort(404);
		} catch (Exception $e) {
			// POUR PHP 5 (pour benou)
			App::abort(404);
		}

		return Redirect::action('ConditionsParticulieresController@index');
	}


}
