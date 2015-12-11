<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use App\Models\Terrain;
use App\Models\Region;
use App\Models\Sport;


use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les terrains
 * 
 * @author FUZZ
 * @version 0.1
 */
class TerrainsController extends BaseController {

    /**
     * Affiche une liste de ressource.
     *
     * @return Response
     */
    public function index()
    {
        try {
            $terrains = Terrain::all();
            foreach ($terrains as $terrain) {
                if ($terrain->description_courte === "" || $terrain->description_courte === NULL){
                    $terrain->description_courte = "Aucune description";
                }
            }
            return View::make('terrains.index', compact('terrains'));
        } catch(Exception $e) {
            App::abort(404);
        }
    }

    /**
     * Affiche le formulaire de création de la ressource.
     *
     * @return Response
     */
    public function create()
    {
        try {
            $regions = Region::all();
            $sports = Sport::all();

            return View::make('terrains.create', compact('regions', 'sports')); 
        } catch(Exception $e) {
            App::abort(404);
        }
    }

    /**
     * Enregistre dans la bd la ressource qui vient d'être créée.
     *
     * @return Response
     */
    public function store()
    {
        try {
            $input = Input::all();
            $terrain = new Terrain;
            $terrain->nom = $input['nom'];
            $terrain->adresse = $input['adresse'];
            $terrain->ville = $input['ville'];
            $terrain->region_id = $input['region_id'];
            $terrain->description_courte = $input['description_courte'];

            if($terrain->save()) {
                if (is_array(Input::get('sport'))) {
                    $terrain->sports()->attach(array_keys(Input::get('sport')));
                }
                return Redirect::action('TerrainsController@index')->with('status', 'Terrain ajouté!');
            } else {
                return Redirect::back()->withInput()->withErrors($terrain->validationMessages());
            }   
        } catch(Exception $e) {
            App::abort(404);
        }  
    }


    /**
     * Affiche la ressource.
     *
     * @param  int  $id l'id du terrain à afficher
     * @return Response
     */
    public function show($id)
    {
        try {
            $terrain = Terrain::findOrFail($id);
            $region = Region::findOrFail($terrain->region_id);
            $terrainSports = Terrain::find($id)->sports;
            $sports = Sport::all();
            if ($terrain->description_courte === ""){
                $terrain->description_courte = "Aucune description";
            }
            return View::make('terrains.show', compact('terrain', 'region', 'sports', 'terrainSports'));
        } catch(Exception $e) {
            App::abort(404);
        }
    }


    /**
     * Affiche le formulaire pour éditer la ressource.
     *
     * @param  int  $id l'id du terrain à éditer 
     * @return Response
     */
    public function edit($id)
    {
        try {
            $terrain = Terrain::findOrFail($id);
            $regions = Region::all();
            $terrainSports = Terrain::find($id)->sports;
            $sports = Sport::all();
            return View::make('terrains.edit', compact('terrain', 'regions', 'sports', 'terrainSports'));
        } catch(Exception $e) {
            App::abort(404);
        }
    }


    /**
     * Mise à jour de la ressource dans la bd.
     *
     * @param  int  $id l'id du terrain à changer.
     * @return Response
     */
    public function update($id)
    {
        try {
            $input = Input::all();
            $terrain = Terrain::findOrFail($id);
            $terrain->nom = $input['nom'];
            $terrain->adresse = $input['adresse'];
            $terrain->ville = $input['ville'];
            $terrain->region_id = $input['region_id'];
            $terrain->description_courte = $input['description_courte'];

            if($terrain->save()) {
                if (is_array(Input::get('sport'))) {
                    $terrain->sports()->sync(array_keys(Input::get('sport')));
                } else {
                    $terrain->sports()->detach();
                }
                return Redirect::action('TerrainsController@index')->with('status', 'Terrain mis à jour!');
            } else {
                return Redirect::back()->withInput()->withErrors($terrain->validationMessages());
            }
        } catch(Exception $e) {
            App::abort(404);
        }
    }

    /**
     * Efface la ressource de la bd.
     *
     * @param  int  $id l'id du terrain à effacer
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $terrain = Terrain::findOrFail($id);
            $terrain->delete();    

            return Redirect::action('TerrainsController@index')->with('status', 'Terrain détruit!');
        } catch(Exception $e) {
            App::abort(404);
        }
    }
}
