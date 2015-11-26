<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use App\Models\Systeme;
use Input;
use Redirect;

//TODO: renommer Systeme pour Activite
class SystemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        //TODO: refaire pour afficher toutes les activités
        $evenement = Systeme::find(1);

        return View::make('systeme.index', compact('evenement'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //TODO: à compléter
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO: à compléter
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //TODO: à compléter
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //TODO: ajouter des try catch.
        $texte = Systeme::find($id);
        return View::make('systeme.edit', compact('texte', 'id'));
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
        $input = Input::all();
        //TODO: ajouter des try catch.
        $texte = Systeme::findOrFail($id);
        $texte->nomEvenement = $input['texte'];

        if($texte->save()) 
        {
            return Redirect::action('SystemeController@index');
        } 
        else 
        {
            return Redirect::back()->withInput()->withErrors($texte->validationMessages());
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
        //TODO: a compléter
    }
}
