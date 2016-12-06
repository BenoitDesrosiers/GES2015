<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;
use DateTime;
use App;

use App\Models\Benevole;
use App\Models\Sport;
use App\Models\Terrain;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Le controller pour les bénévoles
 * 
 * @author Maxime
 * @version 0.1
 */
class BenevolesController extends BaseController {

	/**
	 * Affiche une liste de ressource.
	 *
	 * @return Response
	 */
	public function index()
	{
        try {
		    $benevoles = Benevole::all();
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('benevoles.index', compact('benevoles'));
		
	}


	/**
	 * Affiche le formulaire de création de la ressource.
	 *
	 * @return Response
	 */
	public function create()
	{	
		try {
			$sports = Sport::all();
			$terrains = Terrain::all();
			$anneeDefaut = date ( 'Y' ) - 20;
			$moisDefaut = 0;
			$jourDefaut = 0;
		
			$listeAnnees = BenevolesController::generer_liste ( date ( 'Y' ) - 100, 101 );
			$listeMois = BenevolesController::generer_liste ( 1, 12 );
			$listeJours = BenevolesController::generer_liste ( 1, 31 );
		
		} catch (Exception $e) {
			App:abort(404);
		}
		return View::make('benevoles.create', compact('terrains', 'sports', 'benevoleSports', 'benevoleTerrains', 'listeAnnees', 'anneeDefaut', 'listeMois', 'listeJours', 'anneeDefaut', 'moisDefaut', 'jourDefaut' ));
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
        		
		$benevole = new Benevole;
        $benevole->prenom = $input['prenom'];
		$benevole->nom = $input['nom'];
		$benevole->adresse = $input['adresse'];
		$benevole->numTel = $input['numTel'];
        $benevole->numCell = $input['numCell'];
        $benevole->courriel = $input['courriel'];
		$benevole->accreditation = $input['accreditation'];
		$benevole->sexe = $input['sexe'];
		$benevole->verification = $input['verification'];

		 //      Création de la date de naissance à partir des valeurs des trois comboboxes
			$anneeNaissance = $input['annee_naissance']-1;
			$moisNaissance = $input['mois_naissance']-1;
			$jourNaissance = $input['jour_naissance']-1;
			if (checkdate($moisNaissance, $jourNaissance, $anneeNaissance)) {
				$dateTest = new DateTime;
				$dateTest->setDate($anneeNaissance, $moisNaissance, $jourNaissance);
				$benevole->naissance=$dateTest;
			} else {
				$benevole->naissance = "invalide";
			}
			
			if($benevole->save()) {
				// Association avec les sports sélectionnés
				if (is_array(Input::get('sport'))) { //FIXME: protéger avec une transaction dans le try/catch
					$benevole->sports()->sync(array_keys(Input::get('sport')));
				} else {
					$benevole->sports()->detach();
				}
				// Association avec les terrains sélectionnés
				if (is_array(Input::get('terrain'))) {  //FIXME: protéger avec une transaction dans le try/catch
					$benevole->terrains()->sync(array_keys(Input::get('terrain')));
				} else {
					$benevole->terrain()->detach();
				}
				// Message de confirmation si la sauvegarde a réussi
				return Redirect::action('BenevolesController@create')->with ( 'status', 'Le bénévole a été créé.' );
			} else {
				return Redirect::back()->withInput()->withErrors($benevole->validationMessages());
			}
		} catch (Exception $e) {
			App:abort(404);
		}
	}

  
		




	/**
	 * Affiche la ressource.
	 *
	 * @param  int  $id l'id du bénévole à afficher
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$benevole = Benevole::findOrFail($id);
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('benevoles.show', compact('benevole'));
	}
   
	/**
	 * Affiche le formulaire pour éditer la ressource.
	 *
	 * @param  int  $id l'id du bénévole à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
        try{
		    $benevole = Benevole::findOrFail($id);
		    $sports = Sport::all();
		    $benevoleSports = Benevole::find($id)->sports;
		    $terrains = Terrain::all();
			$benevoleTerrains = Benevole::find($id)->terrains;
			$anneeDefaut = date('Y')- 20;
			$moisDefaut = 0;
			$jourDefaut = 0;
			if ($benevole->naissance) {
	//          Déterminer les valeurs des trois comboboxes
				$stringsDate = explode('-',$benevole->naissance);
				$anneeDefaut = $stringsDate[0]+1;
				$moisDefaut = $stringsDate[1]+1;
				$jourDefaut = $stringsDate[2]+1;
			}
	//      Générer les listes des comboboxes
			$listeAnnees = BenevolesController::generer_liste(date('Y')-100, 101);
			$listeMois = BenevolesController::generer_liste(1, 12);
			$listeJours = BenevolesController::generer_liste(1, 31);
			
        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }

		return View::make('benevoles.edit', compact('benevole', 'terrains', 'sports', 'benevoleSports', 'benevoleTerrains', 'listeAnnees', 'listeMois', 'listeJours','anneeDefaut','moisDefaut','jourDefaut'));
	}


	    /**
     * Construit une liste continue d'entiers sur un intervalle donné
     *
     * @param int $debut La valeur de départ
     * @param int $n     Le nombre de valeurs à inclure
     * @return La liste remplie
     */
    public static function generer_liste($debut, $n) {
        $liste = array();
        $fin = $debut+$n-1;
        for ($i = $debut; $i <= $fin; $i++) {
            $liste[$i+1] = $i;
        }
        return $liste;
    }


	/**
	 * Mise à jour de la ressource dans la bd.
	 *
	 * @param  int  $id l'id du bénévole à changer.
	 * @return Response
	 */
	public function update($id)
{
        try {
	        $input = Input::all();
	
	        $benevole = Benevole::findOrFail($id);
	        $benevole->prenom = $input['prenom'];
            $benevole->nom = $input['nom'];
	        $benevole->adresse = $input['adresse'];
	        $benevole->numTel = $input['numTel'];
            $benevole->numCell = $input['numCell'];
            $benevole->courriel = $input['courriel'];
	        $benevole->accreditation = $input['accreditation'];

	        $benevole->sexe = $input['sexe'];

	        $benevole->verification = $input['verification'];

	        //      	Création de la date de naissance à partir des valeurs des trois comboboxes
			$anneeNaissance = $input['annee_naissance']-1;
			$moisNaissance = $input['mois_naissance']-1;
			$jourNaissance = $input['jour_naissance']-1;
			if (checkdate($moisNaissance, $jourNaissance, $anneeNaissance)) {
				$dateTest = new DateTime;
				$dateTest->setDate($anneeNaissance, $moisNaissance, $jourNaissance);
				$benevole->naissance=$dateTest;
			} else {
// 				Un message d'erreur sera généré lors de la validation
				$benevole->naissance = "invalide";
			}
	
	        if($benevole->save()) {
	        	
	        	// Association avec les sports sélectionnés
	        	if (is_array(Input::get('sport'))) {//FIXME: protéger avec une transaction dans le try/catch
	        		$benevole->sports()->sync(array_keys(Input::get('sport')));
	        	} else {
	        		$benevole->sports()->detach();
	        	}
	        	// Association avec les terrains sélectionnés
	        	if (is_array(Input::get('terrain'))) {//FIXME: protéger avec une transaction dans le try/catch
					$benevole->terrains()->sync(array_keys(Input::get('terrain')));
				} else {
					$benevole->terrains()->detach();
				}
				// Message de confirmation si la sauvegarde a réussi
				return Redirect::action('BenevolesController@show', $benevole->id)->with ( 'status', 'Le benevole a été mis a jour!' );
	        } else {
		        return Redirect::back()->withInput()->withErrors($benevole->validationMessages());
	        }
        }
        catch (ModelNotFoundException $e) {
                    App::abort(404);
        }

	}

    


	/**
	 * Efface la ressource de la bd.
	 *
	 * @param  int  $id l'id du benevole à effacer
	 * @return Response
	 */
	public function destroy($id)
	{
        try{
		    $benevole = Benevole::findOrFail($id);
		    $benevole->delete(); //FIXME: protéger avec une transaction dans le try/catch
		 } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
		return Redirect::action('BenevolesController@index');
	
	}


	/**
	 * Vérifie les doublons dans les bénévoles
	 *
	 * @return Response
	 */
	public function verifierdoublons()
	{
			$listeBenevoleDoublons = collect();
			$benevoles = Benevole::all();
			$benevoleNonClasse = collect();

			
			foreach ($benevoles as $benevole){
				$benevoleDoublesList = Benevole::where('id','!=', $benevole->id)->get();
		 		foreach ($benevoleDoublesList as $benevole2){
		 			if($benevole->nom == $benevole2->nom || $benevole->prenom == $benevole2->prenom){
		 				if($benevole->naissance == $benevole2->naissance){
			 				$listeBenevoleDoublons->push($benevole, $benevole2);
			 				
		 				}
		 			
		 			}
		 		}
		 	}
			if (!empty($listeBenevoleDoublons)){
				$benevoleNonClasse = $listeBenevoleDoublons;
				$benevoles = $benevoleNonClasse->sortBy('nom');
				return View::make('benevoles.index', compact('benevoles'));

			}
			else
			{
				return View::make('benevoles.index', compact('benevoles'));
			}
			

	}
}