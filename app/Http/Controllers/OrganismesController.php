<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\OrganismesRequest;
use Input;
use Redirect;
use App;
use App\Models\Organisme;
use App\Models\Contact;
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
        $contacts = Contact::all();
        return View::make('organismes.index', compact('organismes', 'contacts'));
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
        try {
            $organisme = new Organisme($request->all());
            $organisme->save();
            return Redirect::action('OrganismesController@index');
        } catch (Exception $e) {
            App:abort(404);
        }
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
        $contacts = Contact::all();
        return View::make('organismes.show', compact('organisme', 'contacts'));
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
        try {
            $organisme = Organisme::findOrFail($id);
            $organisme->nomOrganisme = Input::get('nomOrganisme');
            $organisme->telephone = Input::get('telephone');
            $organisme->description = Input::get('description');
            $organisme->save();
            return Redirect::action('OrganismesController@index');
        } catch (Exception $e) {
            App:abort(404);
        }
    }

    /**
     * Supprime l'organisme choisit de la table 'organismes'.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $organisme = Organisme::findOrFail($id);
            $contacts = Contact::where('organisme_id', $id)->get();
            foreach ($contacts as $contact) {
                $contact->delete();
            }
            $organisme->delete(); //FIXME: proteger par un try/catch et une transaction
            return Redirect::action('OrganismesController@index');
        } catch (Exception $e) {
            App:abort(404);
        }
    }
}
