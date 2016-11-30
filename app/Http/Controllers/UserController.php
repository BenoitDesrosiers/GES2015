<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Response;
use View;

class UserController extends BaseController {

    /**
     * Affichage de tout les usagers
     */
    public function index()
    {
        try {
            $usagers = User::all();
        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }

        return View::make('users.index', compact('usagers'));
    }


    /**
     * Affiche le formulaire permettant de créer un usager.
     *
     * @return View
     */
    public function create()
    {
        $usagers = User::all();
        return View::make('usagers.create', compact('usagers'));
    }

    /**
     * Affiche un usager
     *
     * @param   int $userId l'id de l'usager.
     *
     * @return View
     */
    public function show($id) {
        try {
            $usager = User::findOrFail($id);

            $roles = $usager->roles();
        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }
        return View::make('usagers.show', compact('epreuve', 'roles'));
    }

    /**
     * Affiche le formulaire permettant d'éditer un usager
     *
     * @param[in] int $usagerId l'id de l'usager.
     *
     * @return View
     */
    public function edit($usagerId)
    {
        try {
            $usager = User::findOrFail($usagerId);
            $roles = $usager->roles();
            return View::make('usagers.edit', compact('usager', 'roles'));
        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }
    }

    /**
     * Mise à jour de la ressource dans la bd.
     *
     * @param  int  $id l'id de l'usager à modifier.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        try {
            $input = Input::all();

            $user = User::findOrFail($id);
            $user->name = $input['name'];
            $user->email = $input['email'];
            if($user->save()) {
                return Redirect::action('UsagersController@index')->with('status', 'Usager mis à jour!');
            }
            else {
                return Redirect::back()->withInput()->withErrors($user->validationMessages());
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
            $user = User::findOrFail($id);
            $user->delete();

            return Redirect::action('UserController@index');
        } catch(Exception $e) {
            App::abort(404);
        }
    }

}


