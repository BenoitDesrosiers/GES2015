<?php
/**
 * Le controller pour les postes.
 *
 * @author Nicolas Bisson (ProgBiss)
 */
namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\Poste;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use View;
use Redirect;
use Input;

class PostesController extends Controller
{
    /**
     * Affiche une liste de poste.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $postes = Poste::all()->sortby('nom');
            foreach ($postes as $poste) {
                if ($poste->description == "") {
                    $poste->description = "Aucune description";
                }
            }
        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }
        return View::make('postes.index', compact('postes'));
    }

    /**
     * Affiche le formulaire de création de poste.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('postes.create');
    }

    /**
     * Enregistre dans la base de données le poste qui vient d'être créé.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try {
            $input = Input::all();
            $poste = new Poste;
            $poste->nom = $input['nom'];
            $poste->description = $input['description'];

        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }

        if ($poste->save()) {
            return Redirect::action('PostesController@index');
        } else {
            return Redirect::back()->withInput()->withErrors($poste->validationMessages());
        }
    }

    /**
     * Affiche le poste choisi.
     *
     * @param  int  $id du poste à afficher.
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $poste = Poste::findOrFail($id);
            if ($poste->description == "") {
                $poste->description = "Aucune description.";
            }
        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }
        return View::make('postes.show', compact('poste'));
    }

    /**
     * Affiche le formulaire pour éditer le poste.
     *
     * @param  int  $id du poste à éditer.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $poste = Poste::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }
        return View::make('postes.edit', compact('poste'));
    }

    /**
     * Mets à jour le poste dans la base de données.
     *
     * @param  int  $id du poste à mettre à jour.
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        try {
            $input = Input::all();
            $poste = Poste::findOrFail($id);
            $poste->nom = $input['nom'];
            $poste->description = $input['description'];

        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }

        if ($poste->save()) {
            return Redirect::action('PostesController@index');
        } else {
            return Redirect::back()->withInput()->withErrors($poste->validationMessages());
        }
    }

    /**
     * Efface le poste choisi de la base de données.
     *
     * @param  int  $id du poste à effacer.
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $poste = Poste::findOrFail($id);
            $poste->delete();
        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }
        return Redirect::action('PostesController@index');
    }
}
