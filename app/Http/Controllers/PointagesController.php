<?php

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use App\Models\Pointage;
use App\Models\Sport;
use DB;
use Request;
use View;
use Input;
use Redirect;
use Illuminate\Database\Eloquent\Collection;

class PointagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    	$pointages = Pointage::groupBy("sport_id")->get();//distinct
    	return View::make ( 'pointages.index', compact('pointages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	try {
    		$pointages = [];
    		$idSport = '';
    		$listeSports = PointagesController::getListeSports();
    	} catch ( ModelNotFoundException $e ) {
    		App::abort ( 404 );
    	}
    	return View::make ( 'pointages.create', compact ( 'listeSports', 'pointages', 'idSport') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $listeValeurs = Input::get("valeur");
        $listePositions = array_keys($listeValeurs); 
        $idSport = Input::get("listeSports");
        $pointages = [];
        $erreurs = [];
        if(Sport::where ( 'id', $idSport )->get ()) {
        	foreach ($listePositions as $position){
		        			$pointage = new Pointage();
		        			$pointage->sport_id  = $idSport;
		        			$pointage->position  = $position;
		        			$pointage->valeur  = $listeValeurs[$position];
		        			$pointages[] = $pointage;
        	}
        	DB::beginTransaction();
        		$ok = true;
        		Pointage::where('sport_id', $idSport )->delete();
	        	foreach ($pointages as $pointage) {
	        		if($pointage->save()){
	        			
	        		} else {
	        			$ok=false;
	        		}
	        	}
	        	if($ok){
	        		DB::commit();
	            	return Redirect::action('PointagesController@index');
	        	} else {
	        		DB::rollback();
	        		$sport = Sport::where('id', $idSport )->first();
    				return View::make ( 'pointages.edit', compact ( 'sport', 'pointages'));
	        	}
        } else {
        	App::abort(404);
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
		try {
			$pointages = Pointage::where('sport_id', $id )->get();
		} catch ( ModelNotFoundException $e ) {
			App::abort ( 404 );
		}
		return View::make ( 'pointages.show', compact ( 'pointages') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idSport){
    	try {
    		$pointages = Pointage::where('sport_id', $idSport )->get();
    		$sport = Sport::where('id', $idSport )->first();
    	} catch ( ModelNotFoundException $e ) {
    		App::abort ( 404 );
    	}
    	return View::make ( 'pointages.edit', compact ( 'sport', 'pointages') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id){
    $listeValeurs = Input::get("valeur");
        $listePositions = array_keys($listeValeurs);
        $pointages = [];
        $erreurs = [];
        if(Sport::where ( 'id', $id )->get ()) {
        	foreach ($listePositions as $position){
		        			$pointage = new Pointage();
		        			$pointage->sport_id  = $id;
		        			$pointage->position  = $position;
		        			$pointage->valeur  = $listeValeurs[$position];
		        			$pointages[] = $pointage;
        	}
        	DB::beginTransaction();
        		$ok = true;
        		Pointage::where('sport_id', $id )->delete();
	        	foreach ($pointages as $pointage) {
	        		if($pointage->save()){
	        			
	        		} else {
	        			$ok=false;
	        		}
	        	}
	        	if($ok){
	        		DB::commit();
	            	return Redirect::action('PointagesController@index');
	        	} else {
	        		DB::rollback();
	        		$sport = Sport::where('id', $id )->first();
    				return View::make ( 'pointages.edit', compact ( 'sport', 'pointages') );
	        	}
        } else {
        	App::abort(404);
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
    	try {
    		Pointage::where('sport_id', $id)->delete();
    		return Redirect::action ( 'PointagesController@index' );
    	} catch ( ModelNotFoundException $e ) {
    		App::abort ( 404 );
    	}
    }
    
    /**
     * Retourne la liste des sports.
     *
     * @return Array $listeSports. Contient les sports.
     */
    private function getListeSports() {
    	$sports = Sport::all('nom');
    	$listeSports = [];
    	foreach ($sports as $sport){
    		array_push($listeSports, $sport->nom);
    	}
    	array_unshift($listeSports, 'Choisir un sport');
    	return $listeSports;
    }
    
    /**
     * retourne la liste des pointages pour un sport en format JSON
     *
     * Doit être appelé par un call AJAX.
     *
     * @param[in] post int sportId l'id du sport pour lequel on veut lister les pointages
     * @return la sous-view pour afficher une liste de pointages.
     *
     */
    
    public function pointagesPourSport() {
    	if(Request::ajax()) {
    		$sportId = Input::get('sportId');
	    	try {
				return $pointages = Pointage::where('sport_id', $sportId )->get();				
			} catch ( ModelNotFoundException $e ) {
				App::abort ( 404 );
			}
    	} else {
    		return App::abort(404);
    	}
    }
}
