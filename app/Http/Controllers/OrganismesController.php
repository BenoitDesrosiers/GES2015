<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\OrganismesRequest;
use Input;
use Redirect;
use App\Models\Organisme;
use View;

/**
 * Le controlleur pour les organismes
 *
 * @author ettdro
 */
class OrganismesController extends Controller
{
    /**
     * Liste tous les organismes ainsi que leurs contacts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organismes = Organisme::all();
        return View::make('organismes.index', compact('organismes'));
    }
    
    /**
     * Affiche la vue pour créer un organisme.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('organismes.create');
    }

    /**
     * Inscrit un nouvel organisme dans la table 'organismes'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganismesRequest $request)
    {
        $organisme = new Organisme($request->all());
        $organisme->save(); //FIXME: bien qu'on soit protégé par le request, ca peut quand même planté au niveau de la BD. Protéger par un try/catch
        return Redirect::action('OrganismesController@index');
    }

    /**
     * Affiche les informations d'un organisme.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organisme = Organisme::findOrFail($id);
        return View::make('organismes.show', compact('organisme'));
    }

    /**
     * Affiche la vue pour modifier un organisme.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organisme = Organisme::findOrFail($id);
        return View::make('organismes.edit', compact('organisme'));
    }

    /**
     * Met à jour l'organisme choisit dans la table 'organismes'.
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrganismesRequest $request, $id)
    {
        $organisme = Organisme::findOrFail($id);
        $organisme->nomOrganisme = Input::get('nomOrganisme');
        $organisme->telephone = Input::get('telephone');
        $organisme->description = Input::get('description');

        $organisme->save(); //FIXME: bien qu'on soit protégé par le request, ca peut quand même planté au niveau de la BD. Protéger par un try/catch
        return Redirect::action('OrganismesController@index');
    }

    /**
     * Supprime l'organisme choisit de la table 'organismes'.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organisme = Organisme::findOrFail($id);
        $organisme->delete(); //FIXME: proteger par un try/catch et une transaction
        return Redirect::action('OrganismesController@index');
    }
}
