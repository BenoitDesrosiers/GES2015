<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;
use DateTime;

use Participant;
use Region;
use Sport;

use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les participants
 * 
 * @author BinarMorker
 * @version 0.0.1 rev 1
 */
class ParticipantsController extends BaseController {

	/**
	 * Affiche une liste de tous les participants.
	 *
	 * @return Response
	 */
	public function index()
	{
		$participants = Participant::all();
		
		return View::make('participants.index', compact('participants'));
		
	}


	/**
	 * Affiche le formulaire de création d'un participant.
	 *
	 * @return Response
	 */
	public function create()
	{
// 		$regions = Region::all();
// 		$sports = Sport::all();
// 
// 		return View::make('participants.edit', compact('regions', 'sports'));
        $regions = Region::all();
        $sports = Sport::all();
        
        $anneeDefaut = date('Y')- 20;
        $moisDefaut = 0;
        $jourDefaut = 0;
        
        $listeAnnees = ParticipantsController::generer_liste(date('Y')-100, 101);
        $listeMois = ParticipantsController::generer_liste(1, 12);
        $listeJours = ParticipantsController::generer_liste(1, 31);
        return View::make('participants.create', compact('regions', 'sports', 'participantSports', 'listeAnnees', 'anneeDefaut', 'listeMois', 'listeJours', 'anneeDefaut', 'moisDefaut', 'jourDefaut'));
	}


	/**
	 * Enregistre dans la bd le participant qui vient d'être créé.
	 *
	 * @return Response
	 */
	public function store()
	{
// 		$input = Input::all();
// 		if(isset($input['equipe'])) {				
// 			$input['equipe'] = '1';
// 		} else {
// 			$input['equipe'] = '0';
// 		} 
// 
// 		$participant = new Participant;
// 		$participant->nom = $input['nom'];
// 		$participant->prenom = $input['prenom'];
// 		$participant->numero = $input['numero'];
// 		$participant->region_id = $input['region_id'];
// 		$participant->equipe = $input['equipe'];
// 		
// 		if($participant->save()) {
// 			if (is_array(Input::get('sport'))) {
// 				$participant->sports()->attach(array_keys(Input::get('sport')));
// 			}
// 			return Redirect::action('ParticipantsController@index');
// 		} else {
// 			return Redirect::back()->withInput()->withErrors($participant->validationMessages);
// 		}	
        $erreurs = array();
        $input = Input::all();
        $participant = new Participant;
        if(Input::has('equipe')) {
            $participant->equipe = true;
        } else {
            $participant->equipe = false;
        }
        if ($input['nom'] != '') {
            $participant->nom = $input['nom'];
        } else {
            $erreurs['nom'] = 'Nom invalide!';
        }
        if ($input['prenom'] != '') {
            $participant->prenom = $input['prenom'];
        } else {
            $erreurs['prenom'] = 'Prénom invalide!';
        }
        if ($input['telephone'] != '') {
            $participant->telephone = $input['telephone'];
        }
        if ($input['nom_parent'] != '') {
            $participant->nom_parent = $input['nom_parent'];
        }
        if ($input['numero'] != '') {
            $participant->numero = $input['numero'];
        } else {
            $erreurs['numero'] = 'Numéro invalide!';
        }
        if ($input['sexe'] != '') {
            $participant->sexe = $input['sexe'];
        } else {
            $erreurs['sexe'] = 'Genre invalide!';
        }
        if ($input['adresse'] != '') {
            $participant->adresse = $input['adresse'];
        }
        if ($input['region_id'] != '') {
            $participant->region_id = $input['region_id'];
        } else {
            $erreurs['region_id'] = 'Région invalide!';
        }

        $anneeString = $input['annee_naissance']-1;
        $moisString = $input['mois_naissance']-1;
        $jourString = $input['jour_naissance']-1;

        if (ParticipantsController::jour_valide($anneeString, $moisString, $jourString)) {
            $dateTest = new DateTime;
            $dateTest->setDate($anneeString, $moisString, $jourString);
            $participant->naissance=$dateTest;
        } else {
            $erreurs['naissance'] = 'Date de naissance invalide!';
        }
        
        if(count($erreurs) == 0) {
            if($participant->save()) {
                if (is_array(Input::get('sport'))) {
                    $participant->sports()->sync(array_keys(Input::get('sport')));
                } else {
                    $participant->sports()->detach();
                }
                return Redirect::action('ParticipantsController@create')->with ( 'status', 'Le partipant a été créé!' );
            } else {
                return Redirect::back()->withInput()->withErrors($participant->validationMessages);
            }
        } else {
            return Redirect::action('ParticipantsController@create', $participant->id)->with ( 'erreurs', $erreurs );
        }
		
	}


	/**
	 * Affiche un seul participant.
	 *
	 * @param  int  $id l'id du participant à afficher
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$participant = Participant::findOrFail($id);
			$region = Region::findOrFail($participant->region_id);
			$participantSports = Participant::find($id)->sports;
			$sports = Sport::all();
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('participants.show', compact('participant', 'region', 'sports', 'participantSports'));
	}


	/**
	 * Affiche le formulaire pour éditer un participant.
	 *
	 * @param  int $id l'id du participant à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
		$participant = Participant::findOrFail($id);
		$regions = Region::all();
        $sports = Sport::all();
		$participantSports = Participant::find($id)->sports;
        
        $anneeDefaut = date('Y')- 20;
        $moisDefaut = 0;
        $jourDefaut = 0;
        if ($participant->naissance) {
            $stringsDate = explode('-',$participant->naissance);
            $anneeDefaut = $stringsDate[0]+1;
            $moisDefaut = $stringsDate[1]+1;
            $jourDefaut = $stringsDate[2]+1;
        }
        
        $listeAnnees = ParticipantsController::generer_liste(date('Y')-100, 101);
        $listeMois = ParticipantsController::generer_liste(1, 12);
        $listeJours = ParticipantsController::generer_liste(1, 31);
		return View::make('participants.edit', compact('participant', 'regions', 'sports', 'participantSports', 'listeAnnees', 'anneeDefaut', 'listeMois', 'listeJours', 'anneeDefaut', 'moisDefaut', 'jourDefaut'));
	}
    
    private function generer_liste($debut, $n) {
        $liste = array();
        $fin = $debut+$n-1;
        for ($i=$debut; $i<=$fin; $i++) {
            $liste[$i+1] = $i;
        }
        return $liste;
    }

    /**
     * Mise à jour du participant dans la bd.
     *
     * @param  int $id l'id du participant à changer.
     * @return Response
     */
    public function update($id)
    {
        $erreurs = array();
        $input = Input::all();
        $participant = Participant::findOrFail($id);
        if(Input::has('equipe')) {
            $participant->equipe = true;
        } else {
            $participant->equipe = false;
        }
        if ($input['nom'] != '') {
            $participant->nom = $input['nom'];
        } else {
            $erreurs['nom'] = 'Nom invalide!';
        }
        if ($input['prenom'] != '') {
            $participant->prenom = $input['prenom'];
        } else {
            $erreurs['prenom'] = 'Prénom invalide!';
        }
        if ($input['telephone'] != '') {
            $participant->telephone = $input['telephone'];
        }
        if ($input['nom_parent'] != '') {
            $participant->nom_parent = $input['nom_parent'];
        }
        if ($input['numero'] != '') {
            $participant->numero = $input['numero'];
        } else {
            $erreurs['numero'] = 'Numéro invalide!';
        }
        if ($input['sexe'] != '') {
            $participant->sexe = $input['sexe'];
        } else {
            $erreurs['sexe'] = 'Genre invalide!';
        }
        if ($input['adresse'] != '') {
            $participant->adresse = $input['adresse'];
        }
        if ($input['region_id'] != '') {
            $participant->region_id = $input['region_id'];
        } else {
            $erreurs['region_id'] = 'Région invalide!';
        }

        $anneeString = $input['annee_naissance']-1;
        $moisString = $input['mois_naissance']-1;
        $jourString = $input['jour_naissance']-1;

        if (ParticipantsController::jour_valide($anneeString, $moisString, $jourString)) {
            $dateTest = new DateTime;
            $dateTest->setDate($anneeString, $moisString, $jourString);
            $participant->naissance=$dateTest;
        } else {
            $erreurs['naissance'] = 'Date de naissance invalide!';
        }
        
        if(count($erreurs) == 0) {
            if($participant->save()) {
                if (is_array(Input::get('sport'))) {
                    $participant->sports()->sync(array_keys(Input::get('sport')));
                } else {
                    $participant->sports()->detach();
                }
                return Redirect::action('ParticipantsController@edit', $participant->id)->with ( 'status', 'Le partipant ' . $id . ' a été mis a jour!' );
            } else {
                return Redirect::back()->withInput()->withErrors($participant->validationMessages);
            }
        } else {
            return Redirect::action('ParticipantsController@edit', $participant->id)->with ( 'erreurs', $erreurs );
        }
    }

	/**
	 * Efface un participant de la bd.
	 *
	 * @param  int $id l'id du participant à effacer
	 * @return Response
	 */
	public function destroy($id)
	{
		$participant = Participant::findOrFail($id);
		$participant->delete();
		
		return Redirect::action('ParticipantsController@index');
	}


    /**
     * Vérifie que le mois peut inclure le jour
     * @param  int $annee l'annee a verifier (pour annees bisextiles)
     * @param  int $mois le numero du mois a verifier
     * @param  int $jour le numero du jours a valider
     * @return Response
     */
    private function jour_valide($annee, $mois, $jour)
    {
        $mois31 = array(1, 3, 5, 7, 8, 10, 12);
        $mois30 = array(4, 6, 9, 11);
        if (in_array($mois, $mois31)) {
            return $jour <= 31;
        } elseif (in_array($mois, $mois30)) {
            return $jour <= 30;
        } elseif ($annee % 4 == 0) {
            return $jour <= 29;
        } else {
            return $jour <= 28;
        }
    }


}
