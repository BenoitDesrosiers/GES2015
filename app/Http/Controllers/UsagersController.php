<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\StoreUsager;
use App\Http\Requests\UpdateCurrentUserRequest;
use App\Http\Requests\UpdateUsagerRequest;
use App\Models\Role;
use App\User;
use Auth;
use Entrust;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Input;
use Redirect;
use View;

class UsagersController extends Controller
{

    /**
     * Affiche la liste des usagers.
     *
     * @return \Illuminate\Http\Response
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
     * Affiche un formulaire de création d'usager.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $usagers = User::all();
            $roles = Role::all();
        } catch (ModelNotFoundException $e){
            App::abort(404);
        }
        return View::make('users.create', compact('usagers', 'roles'));
    }

    /**
     * Enregistre le tout nouveau usager dans la base de données.
     *
     * @param StoreUsager $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUsager $request)
    {
        try {
            if (Entrust::hasRole('admin')){
                $input = Input::all();
                $usager = new User();
                $usager->name = $input['nom'];
                $usager->email = $input['courriel'];
                $usager->password = Hash::make($input['mot_de_passe']);
                if ($usager->save()){
                    try{
                        $rolesUsager = $input['role'];
                        foreach($rolesUsager as $roleUsager){
                            $roleTemp = $this->getRoleWithName($roleUsager);
                            $usager->attachRole($roleTemp);
                        }
                    } catch (Exception $e){
                        return Redirect::back()->withInput()->withErrors($usager->validationMessages());  // Utilité?
                    }

                    return Redirect::action('UsagersController@index');
                }else{
                    return Redirect::back()->withInput()->withErrors($usager->validationMessages());
                }
            } else {
                App::abort(403);
            }

        } catch (Exception $e){
            App:abort(404);
        }
    }

    /**
     * Affiche les informations de l'usager.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            if (Entrust::hasRole('admin')){
                $usager = User::findOrFail($id);
                $roles = $usager->roles()->get();
                return View::make('users.show', compact('usager','roles'));
            } else {
                App::abort(403);
            }

        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
    }

    /**
     * Affiche un formulaire afin de modifier l'usager.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            if (Entrust::hasRole('admin')){
                $usager = User::findOrFail($id);
                $roles = Role::all();
                return View::make('users.edit', compact('usager', 'roles'));
            } else {
                App::abort(403);
            }

        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }
    }

    /**
     * Met à jour l'usager dans la base de données.
     *
     * @param UpdateUsagerRequest $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUsagerRequest $request, $id)
    {
        try {
            if (Entrust::hasRole('admin')){
                $input = Input::all();
                $usager = User::findOrFail($id);
                $usager->name = $input['nom'];
                $usager->email = $input['courriel'];
                if ($input['mot_de_passe'] != ""){
                    $usager->password = Hash::make($input['mot_de_passe']);
                }
                if ($usager->save()){
                    try{
                        $roles = $usager->roles()->get()->toArray();
                        $rolesPresent = array();
                        foreach ($roles as $role){
                            array_push($rolesPresent, $role['name']);
                        }
                        $rolesUsager = $input['role'];
                        $rolesManquant = array_diff($rolesPresent, $rolesUsager);

                        foreach($rolesManquant as $roleManquant){
                            $roleTemp = $this->getRoleWithName($roleManquant);
                            $usager->detachRole($roleTemp);
                        }

                        foreach($rolesUsager as $roleUsager){
                            if (!($usager->hasRole($roleUsager))){
                                $roleTemp = $this->getRoleWithName($roleUsager);
                                $usager->attachRole($roleTemp);
                            }
                        }

                    } catch (Exception $e){
                        return Redirect::back()->withInput()->withErrors($usager->validationMessages());
                    }
                    return Redirect::action('UsagersController@index');
                }else{
                    return Redirect::back()->withInput()->withErrors($usager->validationMessages());
                }
            } else {
                App::abort(403);
            }
        } catch (Exception $e){
            App:abort(404);
        }
    }

    /**
     * Cette fonction permet d'aller chercher le nom
     * d'un role dans la base de données.
     *
     * @param $name
     *
     * @return mixed
     */
    public function getRoleWithName($name){
        try{
            $role = Role::all()->where('name',$name)->first();
            return $role;
        } catch (Exception $e){
            App:abort(404);
        }
    }


    /**
     * Affiche un formulaire pour modifier l'usager
     * qui est actuellement connecté.
     *
     * @return \Illuminate\Http\Response
     */
    public function editCurrentUser()
    {
        try {
            $usager = Entrust::user();
            return View::make('users.editCurrent', compact('usager'));
        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }
    }

    /**
     * Met à jour les informations de l'usager
     * actuellement connecté.
     *
     * @param UpdateCurrentUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCurrentUser(UpdateCurrentUserRequest $request)
    {
        try {
            $input = Input::all();
            $usager = Entrust::user();
            $userId = Auth::id();

            // On test le mot de passe avant de faire tout changement.
            if ($this->testMotDePasse($userId, $input['ancien_mot_de_passe'])){
                $usager->name = $input['nom'];
                $usager->email = $input['courriel'];
                $usager->password = Hash::make($input['mot_de_passe']);
                if ($usager->save()){
                    return Redirect::action('HomeController@index');
                }else{
                    return Redirect::back()->withInput()->withErrors($usager->validationMessages());
                }
            }else{
                return Redirect::back()->withInput()->withErrors("Il s'agit du mauvais mot de passe.");
            }

        } catch (Exception $e){
            App:abort(404);
        }
    }

    /**
     * Cette fonction test le mot de passe fourni, par l'usager connecté.
     */
    public function testMotDePasse($userId, $password){
        try{
            $reussi = false;
            $usager = User::findOrFail($userId);
            // On essait de se connecter.
            if (Auth::attempt(array('email' => $usager->email, 'password' => $password), false)){
                $reussi = true;
            }
            return $reussi;
        }catch (Exception $e){
            App:abort(404);
        }
    }

    /**
     * Supprimer l'usager de la base de données.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $usager = User::findOrFail($id);
            $usager->delete();
            return Redirect::action('UsagersController@index');
        } catch (Exception $e) {
            App:abort(404);
        }
    }

}
