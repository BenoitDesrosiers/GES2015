<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;
use App\Models\Taches;

class TachesController extends Controller
{
	/**
	 * Affiche une liste de ressource.
	 *
	 * @return Response
	 */
	public function index()
	{
        try {
		    $taches = Taches::all()->sortby('nom');
		    	
		    foreach ($taches as $tache) 
            {
                if ($tache->description == "")
                {
                    $tache->description = "Aucune description disponible";
                }
            }
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('taches.index', compact('taches'));
		
	}


	/**
	 * Affiche le formulaire de création de la ressource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('taches.create');	
	}


	/**
	 * Enregistre dans la bd la ressource qui vient d'être créée.
	 *
	 * @return Response
	 */
	public function store()
	{
        $input = Input::all();
        		
		$tache = new Taches;
        $tache->nom = $input['nom'];
        $tache->description = $input['description'];   
		
		
		if($tache->save()) {
			return Redirect::action('TachesController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($tache->validationMessages());
		}	
	}


	/**
	 * Affiche la ressource.
	 *
	 * @param  int  $id l'id du tâche à afficher
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$tache = Taches::findOrFail($id);
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('taches.show', compact('tache'));
	}

   
	/**
	 * Affiche le formulaire pour éditer la ressource.
	 *
	 * @param  int  $id l'id du tâche à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
        try{
		    $tache = Taches::findOrFail($id);
        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
		return View::make('taches.edit', compact('tache'));
	}

	/**
	 * Mise à jour de la ressource dans la bd.
	 *
	 * @param  int  $id l'id du tâche à changer.
	 * @return Response
	 */
	public function update($id)
	{
        try {
	        $input = Input::all();
	
	        $tache = Taches::findOrFail($id);
	        $tache->nom = $input['nom'];
			$tache->description = $input['description'];   

	
	        if($tache->save()) {
		        return Redirect::action('TachesController@index');
	        } else {
		        return Redirect::back()->withInput()->withErrors($tache->validationMessages());
	        }
        }
        catch (ModelNotFoundException $e) {
                    App::abort(404);
        }
	}

	/**
	 * Efface la ressource de la bd.
	 *
	 * @param  int  $id l'id du tâche à effacer
	 * @return Response
	 */
	public function destroy($id)
	{
        try{
		    $tache = Taches::findOrFail($id);
		    $tache->delete();
		 } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
		return Redirect::action('TachesController@index');
	
	}

}

