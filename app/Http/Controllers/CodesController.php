<?php

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
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('codes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try 
        {
            $input = Input::all();
            
            $code = new Code;
            $code->nom = $input['nom'];
            $code->description = $input['description'];
        } 
        catch(ModelNotFoundException $e) 
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try 
        {
            $code = Code::findOrFail($id);
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
     * Show the form for editing the specified resource.
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
            $code->description = $input['description'];
        } 
        catch(ModelNotFoundException $e) 
        {
            App::abort(404);
        }

        
        if($code->save()) 
        {
            return Redirect::action('CodesController@index');
        } 
        else 
        {
            return Redirect::back()->withInput()->withErrors($role->validationMessages());
        }
    }


    /**
     * Efface la ressource de la bd.
     *
     * @param  int  $id l'id du rôle à effacer
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
