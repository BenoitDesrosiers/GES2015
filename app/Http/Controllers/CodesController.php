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

use App\Models\Code;

class CodesController extends BaseController
{
    /**
     * Affiche une liste des codes trouvés dans la base de données trier en ordre alphabétique.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try 
        {
            $codes = Code::all()->sortby('nom');
            foreach($codes as $code)
            {
                if ($code->abreviation == "")
                {
                        $code->abreviation = "Aucune abréviation disponible";
                }

                if ($code->description == "")
                {
                        $code->description = "Aucune description disponible";
                }
            }
        } 
        catch(ModelNotFoundException $e) 
        {
            App::abort(404);
        }
        return View::make('codes.index', compact('codes'));
    }

    /**
     * Affiche un formulaire de création de code.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('codes.create');
    }

    /**
     * Enregistre le nouveau code dans la base de données après la création.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        try 
        {
            $input = Input::all();
            
            $code = new Code;
            $code->nom = $input['nom'];
            $code->abreviation = $input['abreviation'];
            $code->description = $input['description'];
        } 
        catch(ModelNotFoundException $e) //FIXME: est-ce qu'on peut vraiment avoir un modelnotfound ici?
        {
            App::abort(404);
        }
        
        if($code->save()) 
        {
            return Redirect::action('CodesController@index');
        } 
        else 
        {
            return Redirect::back()->withInput()->withErrors($code->validationMessages());
        }
    }

    /**
     * Affiche un code en particulier en utilisant son Id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try 
        {
            $code = Code::findOrFail($id);
            if ($code->abreviation == "") 
            {
                $code->abreviation = "Aucune abréviation disponible";
            }

            if ($code->description == "") 
            {
                $code->description = "Aucune description disponible";
            }
        } 
        catch(ModelNotFoundException $e) 
        {
            App::abort(404);
        }
        return View::make('codes.show', compact('code'));
    }

    /**
     * Ouvre un formulaire pour modifier un ou plusieurs éléments d'un code en utilisant son Id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try 
        {
            $code = Code::findOrFail($id);
        } 
        catch(ModelNotFoundException $e) 
        {
            App::abort(404);
        }
        return View::make('codes.edit', compact('code'));
    }

    /**
     * Update les nouvelles entrées dans la base de données d'un code en utilisant son Id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        try 
        {
            $input = Input::all();

            $code = Code::findOrFail($id);
            $code->nom = $input['nom'];
            $code->abreviation = $input['abreviation'];
            $code->description = $input['description'];
        } 
        catch(ModelNotFoundException $e) //FIXME: c'est pas juste un modelnotfound qu'on peut pogner ici. Les input peuvent ne pas être bon aussi. 
        {
            App::abort(404);
        }

        
        if($code->save()) 
        {
            return Redirect::action('CodesController@index');
        } 
        else 
        {
            return Redirect::back()->withInput()->withErrors($code->validationMessages());
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
            $code = Code::findOrFail($id);
            $code->delete();
        } 
        catch(ModelNotFoundException $e) 
        {
            App::abort(404);
        }
        return Redirect::action('CodesController@index');
    
    }
}
