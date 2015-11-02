<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;
use DateTime;

use App\Models\Arbitre;
use App\Models\Region;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Le contrôleur pour les arbitres
 * 
 * @author Sarah Laflamme
 * @version 0.0.1 rev 1
 */

class ArbitresController extends BaseController {

	/**
	 * Affiche une liste de tous les arbitres.
	 *
	 * @return Response
	 */
	public function index()
	{
		$arbitres = Arbitre::all();
		
		return View::make('arbitres.index', compact('arbitres'));
		
	}


	/**
	 * Affiche le formulaire de création d'un arbitre.
	 *
	 * @return Response
	 */
	public function create()
	{
		try {
			$regions = Region::all();

			// La date par défaut du formulaire est <cette année> - 20 ans
			// pour être plus prêt de l'âge moyen attendu
	        $anneeDefaut = date('Y')- 20;
	        $moisDefaut = 0;
	        $jourDefaut = 0;

	        // Remplissage des listes pour les choix de la date de naissance
	        $listeAnnees = ArbitresController::generer_liste(date('Y')-100, 101);
	        $listeMois = ArbitresController::generer_liste(1, 12);
	        $listeJours = ArbitresController::generer_liste(1, 31);

			return View::make('arbitres.create', compact('regions', 'listeAnnees', 'anneeDefaut', 'listeMois', 'listeJours', 'anneeDefaut', 'moisDefaut', 'jourDefaut'));

		} catch (Exception $e) {
            App:abort(404);
        }
	}


	/**
	 * Enregistre dans la bd l'arbitre qui vient d'être créé.
	 *
	 * @return Response
	 */
	public function store()
	{
		try {
			$input = Input::all();

			$arbitre = new Arbitre;
			$arbitre->prenom = $input['prenom'];
			$arbitre->nom = $input['nom'];
			$arbitre->region_id = $input['region_id'];
			$arbitre->numero_accreditation = $input['numero_accreditation'];
			$arbitre->association = $input['association'];
			$arbitre->numero_telephone = $input['numero_telephone'];
			$arbitre->adresse = $input['adresse'];
			$arbitre->sexe = $input['sexe'];

			// Création de la date à partir des trois valeurs entrées
			$date_temp = new DateTime;
            $date_temp->setDate($input['annee_naissance']-1, $input['mois_naissance']-1, $input['jour_naissance']-1);
            $arbitre->date_naissance=$date_temp;
			
			if($arbitre->save()) {
				return Redirect::action('ArbitresController@create')->with ( 'status', 'L\'arbitre a été créé.' );
			} else {
				return Redirect::back()->withInput()->withErrors($arbitre->validationMessages());
			}

		} catch (Exception $e) {
            App:abort(404);
        }	
		
	}


	/**
	 * Affiche les informations d'un arbitre
	 *
	 * @param  int  $id l'id de l'arbitre à afficher
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$arbitre = Arbitre::findOrFail($id);
			$region = Region::findOrFail($arbitre->region_id);

		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}

		return View::make('arbitres.show', compact('arbitre', 'region'));
	}


	/**
	 * Affiche le formulaire pour éditer un arbitre.
	 *
	 * @param  int $id l'id de l'arbitre à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
		try {
			$arbitre = Arbitre::findOrFail($id);
			$regions = Region::all();
			
			// La date par défaut du formulaire est <cette année> - 20 ans
			// pour être plus prêt de l'âge moyen attendu
	        $anneeDefaut = date('Y')- 20;
	        $moisDefaut = 0;
	        $jourDefaut = 0;

	        // Remplissage des listes pour les choix de la date de naissance
	        $listeAnnees = ArbitresController::generer_liste(date('Y')-100, 101);
	        $listeMois = ArbitresController::generer_liste(1, 12);
	        $listeJours = ArbitresController::generer_liste(1, 31);

	        return View::make('arbitres.edit', compact('arbitre', 'regions', 'listeAnnees', 'anneeDefaut', 'listeMois', 'listeJours', 'anneeDefaut', 'moisDefaut', 'jourDefaut'));
	    
	    } catch (Exception $e) {
	    	App:abort(404);
	    }
	}

    /**
     * Construit une liste continue d'entiers sur un intervalle donné
     *
     * @param int $debut La valeur de départ
     * @param int $n     Le nombre de valeurs à inclure
     * @return La liste remplie
     */
    private function generer_liste($debut, $n) {
        $liste = array();
        $fin = $debut+$n-1;
        for ($i = $debut; $i <= $fin; $i++) {
            $liste[$i+1] = $i;
        }
        return $liste;
    }


	/**
	 * Mise à jour de l'arbitre dans la bd.
	 *
	 * @param  int $id l'id de l'arbitre à changer.
	 * @return Response
	 */
	public function update($id)
	{
		try {
			$input = Input::all();
			$arbitre = Arbitre::findOrFail($id);
			$arbitre->prenom = $input['prenom'];
			$arbitre->nom = $input['nom'];
			$arbitre->region_id = $input['region_id'];
			$arbitre->numero_accreditation = $input['numero_accreditation'];
			$arbitre->association = $input['association'];
			$arbitre->numero_telephone = $input['numero_telephone'];
			$arbitre->adresse = $input['adresse'];
			$arbitre->sexe = $input['sexe'];

			// Création de la date à partir des trois valeurs entrées
			$date_temp = new DateTime;
	        $date_temp->setDate($input['annee_naissance']-1, $input['mois_naissance']-1, $input['jour_naissance']-1);
	        $arbitre->date_naissance=$date_temp;
			
			if($arbitre->save()) {
				return Redirect::action('ArbitresController@index');
			} else {
				return Redirect::back()->withInput()->withErrors($arbitre->validationMessages());
			}
		}
	}


	/**
	 * Efface un arbitre de la bd.
	 *
	 * @param  int $id l'id de l'arbitre à effacer
	 * @return Response
	 */
	public function destroy($id)
	{
		try {
			$arbitre = Arbitre::findOrFail($id);
			$arbitre->delete();
			
			return Redirect::action('ArbitresController@index');
		}
	
	}


}
