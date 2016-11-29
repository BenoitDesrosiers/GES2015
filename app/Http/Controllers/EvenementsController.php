<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\EvenementsRequest;

use View;
use Redirect;
use Input;

use App\Models\Evenement;
use App\Models\Epreuve;
use App\Models\Terrain;
use App\Models\TypeEvenement;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Le contrôleur pour les événements
 *
 * @author Jessee
 * @version 0.1
 */
class EvenementsController extends BaseController
{
    /**
     * Affiche une liste des ressources.
     *
     * @return Response
     */
    public function index()
    {
        try {
            $evenements = Evenement::all();
            return View::make('evenements.index', compact('evenements'));
        } catch(Exception $e) {
            App::abort(404);
        }
    }

    /**
     * Affiche un formulaire de création d'une nouvelle ressource.
     *
     * @return Response
     */
    public function create()
    {
        try {
            $types = TypeEvenement::all();
            $epreuves = Epreuve::all();
            $terrains = Terrain::all();
            return View::make('evenements.create', compact('types', 'epreuves', 'terrains'));
        } catch(Exception $e) {
            App::abort(404);
        }
    }

    /**
     * Enregistre la nouvelle donnée dans la table 'evenements'
     *
     * @param request   La requête pour valider les données.
     * @return Response
     */
    public function store(EvenementsRequest $request)
    {
        try {
            $input = Input::all();
            $evenement = new Evenement();
            $evenement->nom = $input['nom'];
            $evenement->type_id = $input['type_id'];
            $evenement->epreuve_id = $input['epreuve_id'];
            $evenement->date_heure = $input['date'].' '.$input['heure'];
            if($evenement->save()) {
                return Redirect::action('EvenementsController@index')->with('status', 'Événement ajouté!');
            } else {
                return Redirect::back()->withInput()->withErrors($evenement->validationMessages());
            }
        } catch(Exception $e) {
            App::abort(404);
        }
    }

    /**
     * Affiche un événement selon l'id spécifié.
     *
     * @param  int  $id l'id de l'événement
     * @return Response
     */
    public function show($id)
    {
        try {
            $evenement = Evenement::findOrFail($id);
            return View::make('evenements.show', compact('evenement'));
        } catch(Exception $e) {
            App::abort(404);
        }
    }

    /**
     * Affiche le formulaire pour modifier la donnée.
     *
     * @param  int  $id l'id de l'événement à modifier
     * @return Response
     */
    public function edit($id)
    {
        try {
            $evenement = Evenement::findOrFail($id);
            $types = TypeEvenement::all();
            $epreuves = Epreuve::all();
            $terrains = Terrain::all();
            // La 'date' dans 'date_heure' est enmagasinée avec des '-' comme séparateurs, mais la fonction 'strtotime' utilise des '/' pour séparer la date
            $date = date('Y-m-d', strtotime(str_replace('-', '/', $evenement->date_heure)));
            $heure = date('G:i', strtotime($evenement->date_heure));
            return View::make('evenements.edit', compact('evenement', 'types', 'epreuves', 'terrains', 'date', 'heure'));
        } catch(Exception $e) {
            App::abort(404);
        }
    }

    /**
     * Mettre à jour la donnée dans la table événement.
     *
     * @param  int  $id l'id de l'événement à changer.
     * @param request   La requête pour valider les données.
     * @return Response
     */
    public function update(EvenementsRequest $request, $id)
    {
        try {
            $input = Input::all($request->all());
            $evenement = Evenement::findOrFail($id);
            $evenement->nom = $input['nom'];
            $evenement->type_id = $input['type_id'];
            $evenement->epreuve_id = $input['epreuve_id'];
            $evenement->date_heure = $input['date'].' '.$input['heure'];
            if($evenement->save()) {
                return Redirect::action('EvenementsController@index')->with('status', 'Événement mis à jour!');
            } else {
                return Redirect::back()->withInput()->withErrors($evenement->validationMessages());
            }
        } catch(Exception $e) {
            App::abort(404);
        }
    }

    /**
     * Enlève la donnée de la table événement.
     *
     * @param  int  $id l'id de l'événement à effacer
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $evenement = Evenement::findOrFail($id);
            $evenement->delete(); //FIXME: protéger par une transaction dans le try/catch

            return Redirect::action('EvenementsController@index')->with('status', 'Événement détruit!');
        } catch(Exception $e) {
            App::abort(404);
        }
    }
}
