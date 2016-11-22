<?php
/** 
 * @author GBEY0402
 * @version 0.1
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;
use Redirect;
use Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Association;

class AssociationsController extends BaseController
{
    /**
     * Affiche une liste des associations trouvées dans la base de données trier en ordre alphabétique.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try 
        {
            $associations = Association::all()->sortby('nom');
            foreach($associations as $association)
            {
                if ($association->abreviation == "")
                {
                        $association->abreviation = "Aucune abréviation disponible";
                }

                if ($association->description == "")
                {
                        $association->description = "Aucune description disponible";
                }
            }
        } 
        catch(ModelNotFoundException $e) 
        {
            App::abort(404);
        }
        return View::make('associations.index', compact('associations'));
    }

    /**
     * Affiche un formulaire de création de l'association.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('associations.create');
    }

    /**
     * Enregistre la nouvelle association dans la base de données après la création.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try 
        {
            $input = Input::all();
            
            $association = new Association;
            $association->nom = $input['nom'];
            $association->abreviation = $input['abreviation'];
            $association->description = $input['description'];
        } 
        catch(ModelNotFoundException $e) //FIXME: est-ce qu'on peut vraiment avoir un modelnotfound ici?
        {
            App::abort(404);
        }
        
        if($association->save()) 
        {
            return Redirect::action('AssociationsController@index');
        } 
        else 
        {
            return Redirect::back()->withInput()->withErrors($association->validationMessages());
        }
    }

    /**
     * Affiche une association en particulier en utilisant son Id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try 
        {
            $association = Association::findOrFail($id);
            if ($association->abreviation == "") 
            {
                $association->abreviation = "Aucune abréviation disponible";
            }

            if ($association->description == "") 
            {
                $association->description = "Aucune description disponible";
            }
        } 
        catch(ModelNotFoundException $e) 
        {
            App::abort(404);
        }
        return View::make('associations.show', compact('association'));
    }

    /**
     * Ouvre un formulaire pour modifier un ou plusieurs éléments d'une association en utilisant son Id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try 
        {
            $association = Association::findOrFail($id);
        } 
        catch(ModelNotFoundException $e) 
        {
            App::abort(404);
        }
        return View::make('associations.edit', compact('association'));
    }

    /**
     * Met à jour les nouvelles entrées dans la base de données d'une association en utilisant son Id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        try 
        {
            $input = Input::all();

            $association = Association::findOrFail($id);
            $association->nom = $input['nom'];
            $association->abreviation = $input['abreviation'];
            $association->description = $input['description'];
        } 
        catch(ModelNotFoundException $e) //FIXME: c'est pas juste un modelnotfound qu'on peut pogner ici. Les input peuvent ne pas être bon aussi. 
        {
            App::abort(404);
        }

        
        if($association->save()) 
        {
            return Redirect::action('AssociationsController@index');
        } 
        else 
        {
            return Redirect::back()->withInput()->withErrors($association->validationMessages());
        }
    }


    /**
     * Efface la ressource de la bd en utilisant son Id.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try 
        {
            $association = Association::findOrFail($id);
            $association->delete();
        } 
        catch(ModelNotFoundException $e) 
        {
            App::abort(404);
        }
        return Redirect::action('AssociationsController@index');
    
    }
}
