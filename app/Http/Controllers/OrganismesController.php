<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\OrganismesRequest;
use Input;
use Redirect;
use App\Models\Organisme;
use View;

class OrganismesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organismes = Organisme::all();
        return View::make('organismes.index', compact('organismes'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('organismes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganismesRequest $request)
    {
        $organisme = new Organisme($request->all());
        $organisme->save();
        return Redirect::action('OrganismesController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
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
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $organisme = Organisme::findOrFail($id);
        $organisme->nomOrganisme = Input::get('nomOrganisme');
        $organisme->telephone = Input::get('telephone');
        $organisme->description = Input::get('description');

        $organisme->save();
        return Redirect::action('OrganismesController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $organisme = Organisme::findOrFail($id);
        $organisme->delete();
        return Redirect::action('OrganismesController@index');
    }
}
