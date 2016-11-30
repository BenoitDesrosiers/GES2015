<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\StoreUsager;
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
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usagers = User::all();
        $roles = Role::all();
        return View::make('users.create', compact('usagers', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUsager|Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUsager $request)
    {
        try {
            $input = Input::all();
            $usager = new User();
            $usager->name = $input['nom'];
            $usager->email = $input['courriel'];
            $usager->password = Hash::make($input['mot_de_passe']);
            if ($usager->save()){
                try{
                    $rolesUsager = $input['role'];
                    $usager->attachRoles($rolesUsager);
                } catch (Exception $e){
                    return Redirect::back()->withInput()->withErrors("Un des roles sélectionner est innexistant.");  // Utilité?
                }

                return Redirect::action('UsagersController@index');
            }else{
                return Redirect::back()->withInput()->withErrors($usager->validationMessages());
            }
        } catch (Exception $e){
            App:abort(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $usager = User::findOrFail($id);
            $roles = $usager->roles()->get();
            return View::make('users.show', compact('usager','roles'));
        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $usager = User::findOrFail($id);
            $roles = Role::all();
            return View::make('users.edit', compact('usager', 'roles'));
        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUsager|Request $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreUsager $request, $id)
    {
        try {
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
                    dd($e);
                }
                return Redirect::action('UsagersController@index');
            }else{
                return Redirect::back()->withInput()->withErrors($usager->validationMessages());
            }
        } catch (Exception $e){
            App:abort(404);
        }
    }

    /**
     *
     *
     * @param $name
     *
     * @return mixed
     */
    public function getRoleWithName($name){
        $role = Role::all()->where('name',$name)->first();
        return $role;
    }


    /**
     * Show the form for editing the specified resource.
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
     * Update the specified resource in storage.
     *
     * @param StoreUsager|Request $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCurrentUser(UpdateCurrentUserRequest $request)
    {
        try {
            $input = Input::all();
            $usager = Entrust::user();
            $userId = Auth::id();
            // On test le mot de passe avant de faire tout changement.
            if ($this->testMotDePasse($userId, $input['old_mot_de_passe'])){
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
     * Cette fonction test le mot de passe fournie, par l'usager connecté.
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

        }
    }

    /**
     * Remove the specified resource from storage.
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
