<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use Terrain;
use Region;
use Sport;


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
        $terrains = Terrain::all();
        
        return View::make('terrains.index', compact('terrains'));
        
    }


    /**
     * Affiche le formulaire de création de la ressource.
     *
     * @return Response
     */
    public function create()
    {
        $regions = Region::all();
        $sports = Sport::all();

        return View::make('terrains.create', compact('regions', 'sports')); 
    }


    /**
     * Enregistre dans la bd la ressource qui vient d'être créée.
     *
     * @return Response
     */
    public function store()
    {
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
            return Redirect::back()->withInput()->withErrors($terrain->validationMessages);
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
            $sports = Sport::all();
        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
        return View::make('terrains.show', compact('terrain', 'region', 'sports'));
    }


    /**
     * Affiche le formulaire pour éditer la ressource.
     *
     * @param  int  $id l'id du terrain à éditer 
     * @return Response
     */
    public function edit($id)
    {
        $terrain = Terrain::findOrFail($id);
        $regions = Region::all();
        $sports = Sport::all();
        return View::make('terrains.edit', compact('terrain', 'regions', 'sports'));
    }


    /**
     * Mise à jour de la ressource dans la bd.
     *
     * @param  int  $id l'id du terrain à changer.
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();
        $terrain = Terrain::findOrFail($id);
        $terrain->nom = $input['nom'];
        $terrain->adresse = $input['adresse'];
        $terrain->ville = $input['ville'];
        $terrain->region_id = $input['region_id'];
        $terrain->description_courte = $input['description_courte'];
        
        if($terrain->save()) {
            return Redirect::action('TerrainsController@index')->with('status', 'Terrain mis à jour!');
        } else {
            return Redirect::back()->withInput()->withErrors($terrain->validationMessages);
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
        $terrain = Terrain::findOrFail($id);
        $terrain->delete();
        
        return Redirect::action('TerrainsController@index')->with('status', 'Terrain détruit!');
    
    }


}
