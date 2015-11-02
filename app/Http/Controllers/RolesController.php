<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use App\Models\Role;


use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les rôles.
 * 
 * @author SteveL
 * @version 0.1
 */
class RolesController extends BaseController {

	/**
	 * Affiche une liste de rôle.
	 *
	 * @return Response
	 */
	public function index()
	{
		$roles = Role::all()->sortby('nom');
	
		foreach($roles as $role){
			if ($role->description == "")
				{
					$role->description = "Aucune description";
			}
		}
		return View::make('roles.index', compact('roles'));
	}


	/**
	 * Affiche le formulaire de création de la ressource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('roles.create');	
	}


	/**
	 * Enregistre dans la bd la ressource qui vient d'être créée.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		
		$role = new Role;
		$role->nom = $input['nom'];
		$role->description = $input['description'];
		
		if($role->save()) {
			return Redirect::action('RolesController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($role->validationMessages());
		}	
		
	}


	/**
	 * Affiche la ressource.
	 *
	 * @param  int  $id l'id du rôle à afficher
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$role = Role::findOrFail($id);
			if ($role->description == "") {$role->description = "Aucune description";}
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('roles.show', compact('role'));
	}


	/**
	 * Affiche le formulaire pour éditer la ressource.
	 *
	 * @param  int  $id l'id du rôle à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
		$role = Role::findOrFail($id);
		return View::make('roles.edit', compact('role'));
	}


	/**
	 * Mise à jour de la ressource dans la bd.
	 *
	 * @param  int  $id l'id du rôle à changer.
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();

		$role = Role::findOrFail($id);
		$role->nom = $input['nom'];
		$role->description = $input['description'];
		
		if($role->save()) {
			return Redirect::action('RolesController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($role->validationMessages());
		}
	}


	/**
	 * Efface la ressource de la bd.
	 *
	 * @param  int  $id l'id du rôle à effacer
	 * @return Response
	 */
	public function destroy($id)
	{
		$role = Role::findOrFail($id);
		$role->delete();
		
		return Redirect::action('RolesController@index');
	
	}


}
