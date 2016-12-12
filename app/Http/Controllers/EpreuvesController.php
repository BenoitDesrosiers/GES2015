<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;
use Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;

use App\Models\Sport;
use App\Models\Arbitre;
use App\Models\Region;
use App\Models\Epreuve;
use App\Models\Participant;
use App\Models\EpreuveParticipants;
use App\Models\Terrain;

/**
 * Le controller pour les épreuves liées à un sport
 *
 *
 * @version 0.2
 * @author benou
 */
class EpreuvesController extends BaseController {
	/**
	 * Affichage de toutes les épreuves
	 *
	 * Si un sport est passé en paramètre, il sera choisi par défaut dans la liste
	 *
	 * @param
	 *        	[in] get int sportId l'id du sport auquel est associé l'épreuve.
	 *        	Une valeur absente ou 0 indique de prendre le premier sport de la liste.
	 */
	public function index()
	{	
		$sportId = Input::get('sportId'); //TODO: ajouter un try catch
		$sports = Sport::all();
		$sportId = $this->checkSportId($sports, $sportId);
		 
		return View::make('epreuves.index', compact('sports', 'sportId')); 
	}
	
	/**
	 * Affiche le formulaire permettant de créer une épreuve
	 *
	 * @param
	 *        	[in] get int sportId l'id du sport auquel est associé l'épreuve.
	 *        	Une valeur absente ou 0 indique de prendre le premier sport de la liste.
	 */
	public function create()
	{
		$sportId = Input::get('sportId');
		$sports = Sport::all();
		$arbitres = Arbitre::orderBy('nom', 'asc')->get(); //TODO: quand les arbitres seront associés à un sport, ne prendre que les arbitre du sport associé à l'épreuve
		$sportId = $this->checkSportId($sports, $sportId);
		$terrains = Terrain::all();
		return View::make('epreuves.create', compact('sports', 'sportId', 'arbitres', 'arbitresUtilises', 'terrains'));

	}
	
	/**
	 * Affiche le formulaire permettant d'ajouter un ou des participants/équipes à une épreuve.
	 *
	 * @param[in] get int $epreuveId l'id de l'épreuve qu'on sélectionne.
	 */
	public function ajtParticipant($epreuveId) {
		try{
			$epreuve = Epreuve::findOrFail ( $epreuveId );
			$sport = Sport::findOrFail( $epreuve->sport_id);
            if($epreuve->genre == 'mixte'){
                $participants = $sport->participants->sortBy('prenom');
            }else{
                $genreRequis = ($epreuve->genre == 'féminin');
                $participants = $sport->participants->where('sexe',$genreRequis)->sortBy('prenom');
            }
			$epreuveParticipants = ($epreuve::find($epreuveId)->participants);
		} catch ( ModelNotFoundException $e ) {
			App::abort ( 404 );
		}
		return View::make ( 'epreuves.ajtParticipant', compact ( 'epreuve', 'sport', 'participants', 'epreuveParticipants') );
	}
	
	/**
	 * Entrepose dans la bd un ou des participants/équipes qui seront associés à une épreuve.
	 */
	public function storeParticipants($epreuveId) {	
		$input = Input::all ();
		try {
			$epreuve = Epreuve::findOrFail($epreuveId);
			$sportId = $epreuve->sport->id;
			$sports = Sport::all();
			$arbitresEpreuves = $epreuve->arbitres;
			$arbitres = EpreuvesController::filtrer_arbitres(Arbitre::orderBy('nom', 'asc')->get(), $arbitresEpreuves);
			//FIXME: au lieu d'avoir une fonction pour filtrer les arbitres déjà associés à une épreuve, on peut se servir du whereNotIn
			//       et fournir la liste des ids des arbitresEpreuves
			//       $arbitres = Arbitre::all()->whereNotIn('id', $arbitresEpreuves->pluck('id')) ->get();
			$sportId = $this->checkSportId($sports, $sportId);
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}

		if ($epreuve->save ()) {
			if (is_array ( Input::get ( 'participants' ) )) { //FIXME: protéger par une transaction dans le try/catch
                $epreuve->participants()->sync ( array_keys ( Input::get ( 'participants' )));
			} else {
				$epreuve->participants()->detach();
			}
			return Redirect::action ( 'EpreuvesController@index');
		} else {
			return Redirect::back ()->withInput ()->withErrors ( $epreuve->validationMessages () );
		}
	}
	
	/**
	 * Affiche les participants/équipes associés à l'épreuve sélectionnée par région.
	 *
	 * @param[in] get int $epreuveId l'id de l'épreuve qu'on sélectionne.
	 */
	public function listeParticipant($epreuveId) {
		try{
			$epreuve = Epreuve::findOrFail ( $epreuveId );
			$participants = $epreuve->participants->sortBy('region_id');
		} catch ( ModelNotFoundException $e ) {
			App::abort ( 404 );
		}
		return View::make ( 'epreuves.listeParticipant', compact ( 'epreuve', 'participants') );
	}
	
	/**
	 * Affiche le formulaire permettant d'éditer une épreuve
	 *
	 * @param[in] int $epreuveId l'id de l'épreuve
	 */
	public function edit($epreuveId)
	{
		try {
			$epreuve = Epreuve::findOrFail($epreuveId);
            $sportId = $epreuve->sport->id;
			$sports = Sport::all();
			$arbitresEpreuves = $epreuve->arbitres;

            // Cette partie dénombre le nombre de participants dans l'épreuve qui sont de genre
            // masculin (false) ou féminin (true)
            $participantsMasculin = $epreuve->participants->where('sexe', false);
            $participantsFeminin = $epreuve->participants->where('sexe', true);
            $proportionGenre = array(count($participantsMasculin),count($participantsFeminin));
			$arbitres = EpreuvesController::filtrer_arbitres(Arbitre::orderBy('nom', 'asc')->get(), $arbitresEpreuves);
			//FIXME: au lieu d'avoir une fonction pour filtrer les arbitres déjà associés à une épreuve, on peut se servir du whereNotIn
			//       et fournir la liste des ids des arbitresEpreuves
			//       $arbitres = Arbitre::all()->whereNotIn('id', $arbitresEpreuves->pluck('id')) ->get();
			$sportId = $this->checkSportId($sports, $sportId);
			$epreuveTerrains = $this->listerTerrains($epreuveId);

			return View::make('epreuves.edit', compact('epreuve', 'sports', 'sportId', 'proportionGenre', 'arbitres', 'arbitresEpreuves', 'epreuveTerrains'));
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
    }

	/**
	 * Affiche une épreuve
	 *
	 * @param
	 *        	[in] int $epreuveId l'id de l'épreuve
	 */
	public function show($epreuveId) {
		try {
			$epreuve = Epreuve::findOrFail($epreuveId);
			$arbitresEpreuves = $epreuve->arbitres;
			$terrainsEpreuve = $epreuve->terrains;
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}

		return View::make('epreuves.show', compact('epreuve', 'arbitresEpreuves'));
	}	

	/**
	 * Entrepose dans la bd une nouvelle épreuve qui sera associée à un sport
	 */
	public function store()
	{ //FIXME: presque le même code que update, DRY
		$input = Input::all();
		try {
			$sport = Sport::findOrFail ( $input ["sportsListe"] );
		} catch ( ModelNotFoundException $e ) {
			App::abort ( 404 );
		}
		$epreuve = new Epreuve;
		$epreuve->nom = $input['nom'];
        $epreuve->genre = $input['genre'];
		$epreuve->description = $input['description'];
		$epreuve->sport_id = $sport->id; 
		if($epreuve->save()) {
			try { //FIXME: protéger par une transaction dans le try/catch
				$arbitresAEntrer = explode(",",Input::get('arbitresUtilises'));
				//Vérification qu'il y a bien un arbitre à entrer dans la BD.
                if (EpreuvesController::verifier_existence($arbitresAEntrer)) {
                    $epreuve->arbitres()->sync($arbitresAEntrer);
                } else {
                	$epreuve->arbitres()->detach();
            	}
			} catch (Exception $e) {
				App::abort(404);
			}
			//Association des terrains
			if (is_array(Input::get('terrain'))) {
				$epreuve->terrains()->sync(array_keys(Input::get('terrain')));
			} else {
				$epreuve->terrains()->detach();
			}
			return Redirect::action ( 'EpreuvesController@index', array (
									  'sportId' => $input ["sportsListe"]));
		} else {
			return Redirect::back ()->withInput ()->withErrors ( $epreuve->validationMessages () );
		}
	}

	/**
	 * Mise à jour d'une épreuve associée
	 *
	 * @param
	 *        	[in] int $epreuveId l'id de l'épreuve
	 */
	public function update( $epreuveId)
	{  //FIXME: presque le même code que store, DRY
		$input = Input::all();
		try {
			$epreuve = Epreuve::findOrFail ( $epreuveId );
		} catch ( Exception $e ) {
			App::abort ( 404 );
		}
		$epreuve->nom = $input ['nom'];
        $epreuve->genre = $input ['genre'];
		$epreuve->description = $input ['description'];
		try {
			$sport = Sport::findOrFail ( $input ["sportsListe"] );
		} catch ( ModelNotFoundException $e ) {
			App::abort ( 404 );
		}
		$epreuve->sport_id = $sport->id;

		if($epreuve->save()) {
            $epreuve->participants()->sync($this->filtrer_participants($epreuveId));
			$arbitresAEntrer = explode(",",Input::get('arbitresUtilises'));
			//Vérification qu'il y ai bien un arbitre à entrer dans la BD.
            if (EpreuvesController::verifier_existence($arbitresAEntrer)) {
                $epreuve->arbitres()->sync($arbitresAEntrer);
            } else {
                $epreuve->arbitres()->detach();
            }
            //Association des terrains
            if (is_array(Input::get('terrain'))) {
            	$epreuve->terrains()->sync(array_keys(Input::get('terrain')));
            } else {
            	$epreuve->terrains()->detach();
            }
			return Redirect::action('EpreuvesController@index',array('sportId'=>$input["sportsListe"]));
		} else {
			return Redirect::back ()->withInput ()->withErrors ( $epreuve->validationMessages () );
		}
	}
	
	/**
	 * Efface une épreuve
	 *
	 * @param
	 *        	[in] int $epreuveId l'id de l'épreuve
	 */
	public function destroy($epreuveId) {
		$epreuve = Epreuve::findOrFail ( $epreuveId );
		$epreuve->delete (); //FIXME: protéger par une transaction dans un try/catch
		
		return Redirect::action ( 'EpreuvesController@index' );
	}

    /**
     * Retourne une collection des terrains qui sont associés au sport
     * de l'épreuve. Les propriétés 'checked' et 'active' sont ajoutées
     * aux terrains pour indiquer si le terrain est associé à l'épreuve.
     *
     * @param
     * 			[in] int $epreuveId l'id de l'épreuve
     * @return
     * 			Collection de terrrains
     */
    public function listerTerrains($epreuveId) {
        $epreuve = Epreuve::findOrFail($epreuveId);
        $epreuveTerrains = new Collection();
        $terrains = Terrain::all();
        foreach ($terrains as $terrain) {
            foreach ($terrain->sports as $terrSport) {
                //Vérifie que le sport de l'épreuve est le même que celui du terrain
                if ($terrSport->id == $epreuve->sport->id) {
                    $terrain->checked = "";
                    $terrain->active = "";
                    //Vérifie que le terrain est déjà associé à l'épreuve
                    foreach ($epreuve->terrains as $terrainAssocie) {
                        if ($terrain->id == $terrainAssocie->id) {
                            $terrain->checked = " checked";
                            $terrain->active = " active";
                        }
                    }
                    $epreuveTerrains->add($terrain);
                }
            }
        }
        return $epreuveTerrains;
    }

	/**
	 * retourne la liste des epreuves pour un sport en format JSON
	 *
	 * Doit être appelé par un call AJAX.
	 *
	 * @param
	 *        	[in] post int sportId l'id du sport pour lequel on veut lister les épreuves
	 * @return la sous-view pour afficher une liste d'épreuves.
	 */
	public function epreuvesPourSport() {
		if (Request::ajax ()) {
			$sportId = Input::get ( 'sportId' );
			try {
				$sport = Sport::findOrFail ( $sportId );
			} catch ( ModelNotFoundException $e ) {
				App::abort ( 404 );
			}
			$epreuves = $sport->epreuves;
			return View::make ( 'epreuves.listeEpreuve' )->with ( 'epreuves', $epreuves )->with ( 'sport', $sport );
		} else {
			return App::abort ( 404 );
		}
	}
	
	/**
	 * Verifie si un id de sport existe.
	 * Si oui:le retourne. Si non: retourne l'id du premier sport dans la liste
	 *
	 * @param array $sports
	 *        	liste des sports. Utilisé si $sportId = 0 afin de choisir une valeur par défaut
	 * @param int $sportId
	 *        	un id de sport. Un sport avec cet id doit exister, sinon la le premier id de la liste sera utilisé
	 * @return int
	 */
	protected function checkSportId($sports, $sportId) {
		if ($sportId != 0) {
			// verifie que le sportid passé en paramêtre existe.
			try {
				$sport = Sport::findOrFail ( $sportId );
			} catch ( Exception $e ) {
				// si il n'existe pas, on prend celui du premier sport dans la liste
				$sportId = $sports [0]->id;
			}
		} else {
			// par default on prend le premier sport
			$sportId = $sports [0]->id;
		}
		return $sportId;
	}
	
	/**
	 * Vérifie si les arbitres sont sous formes d'array etsi il y en as. 0 veut dire qu'il n'y a pas d'arbitres.
	 * @param $arbitres
	 * @return boolean
	 */
	protected function verifier_existence($arbitresAEntrer) {
		if (is_array($arbitresAEntrer) AND ($arbitresAEntrer[0] != "0") AND ($arbitresAEntrer[0] !="")) {
			$retour = TRUE;  //FIXME: pourquoi ne pas juste retourner le résultat du IF?
		}else{
			$retour = FALSE;
		}
		return $retour;
	}

    /**
     * Filtre les participants pour retirer ceux n'ayant pas le bon genre..
     *
     * @param int $epreuveId
     *
     * @return array
     */
    protected function filtrer_participants($epreuveId){
        try{
            $epreuve = Epreuve::findOrFail ( $epreuveId );
            $participants = $epreuve->participants;
            if ($epreuve->genre != 'mixte'){
                $genreRequis = $epreuve->genre == 'féminin';
                $participants = $epreuve->participants->where('sexe',$genreRequis);
            }
            return $participants;
        } catch ( ModelNotFoundException $e ) {
            App::abort ( 404 );
        }
    }

    /**
     * filtre les arbitres pour retirer ceux déjà attribués à une épreuve.
     * @param array $arbitres
     * @param array $arbitresEpreuves
     *
     * @return array
     */
	protected function filtrer_arbitres($arbitres, $arbitresEpreuves){
		if ($arbitresEpreuves){
			foreach ($arbitres as $index => $arbitre){
				foreach ($arbitresEpreuves as $arbitreEpreuve) {
					if ($arbitreEpreuve->id == $arbitre->id) {
						$arbitres->pull($index);
					}
				}
			}
		}
		return $arbitres;
	}

}
