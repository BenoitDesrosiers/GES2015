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
        $regions = Region::all();
        $sports = Sport::all();

//      La date par défaut du formulaire est <cette année> - 20 ans
//      pour être plus prêt de l'âge moyen attendu
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
        $input = Input::all();
        $participant = new Participant;

//      Le champ 'equipe' n'est pas transmis s'il n'est pas coché, il faut vérifier autrement
        if(Input::has('equipe')) {
            $participant->equipe = true;
        } else {
            $participant->equipe = false;
        }
        $participant->nom = $input['nom'];
        $participant->prenom = $input['prenom'];
        $participant->telephone = $input['telephone'];
        $participant->nom_parent = $input['nom_parent'];
        $participant->numero = $input['numero'];
        $participant->sexe = $input['sexe'];
        $participant->adresse = $input['adresse'];
        $participant->region_id = $input['region_id'];

//      Création de la date de naissance à partir des valeurs des trois comboboxes
        $dateTest = new DateTime;
        $dateTest->setDate($input['annee_naissance']-1, $input['mois_naissance']-1, $input['jour_naissance']-1);
        $participant->naissance=$dateTest;

        if($participant->save()) {
            if (is_array(Input::get('sport'))) {
                $participant->sports()->sync(array_keys(Input::get('sport')));
            } else {
                $participant->sports()->detach();
            }
//          Message de confirmation si la sauvegarde a réussi
            return Redirect::action('ParticipantsController@create')->with ( 'status', 'Le partipant a été créé!' );
        } else {
            return Redirect::back()->withInput()->withErrors($participant->validationMessages);
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

//      Si de vieilles entrées n'ont pas de date de naissance, on utilise les valeurs par défaut
        $anneeDefaut = date('Y')- 20;
        $moisDefaut = 0;
        $jourDefaut = 0;
        if ($participant->naissance) {
//          Déterminer les valeurs des trois comboboxes
            $stringsDate = explode('-',$participant->naissance);
            $anneeDefaut = $stringsDate[0]+1;
            $moisDefaut = $stringsDate[1]+1;
            $jourDefaut = $stringsDate[2]+1;
        }

//      Générer les listes des comboboxes
        $listeAnnees = ParticipantsController::generer_liste(date('Y')-100, 101);
        $listeMois = ParticipantsController::generer_liste(1, 12);
        $listeJours = ParticipantsController::generer_liste(1, 31);

        return View::make('participants.edit', compact('participant', 'regions', 'sports', 'participantSports', 'listeAnnees', 'anneeDefaut', 'listeMois', 'listeJours', 'anneeDefaut', 'moisDefaut', 'jourDefaut'));
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
     * Mise à jour du participant dans la bd.
     *
     * @param  int $id l'id du participant à changer.
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();

//      Le champ 'equipe' n'est pas transmis s'il n'est pas coché, il faut vérifier autrement
        $participant = Participant::findOrFail($id);
        if(Input::has('equipe')) {
            $participant->equipe = true;
        } else {
            $participant->equipe = false;
        }
        $participant->nom = $input['nom'];
        $participant->prenom = $input['prenom'];
        $participant->telephone = $input['telephone'];
        $participant->nom_parent = $input['nom_parent'];
        $participant->numero = $input['numero'];
        $participant->sexe = $input['sexe'];
        $participant->adresse = $input['adresse'];
        $participant->region_id = $input['region_id'];

//      Création de la date de naissance à partir des valeurs des trois comboboxes
        $dateTest = new DateTime;
        $dateTest->setDate($input['annee_naissance']-1, $input['mois_naissance']-1, $input['jour_naissance']-1);
        $participant->naissance=$dateTest;

        if($participant->save()) {
            if (is_array(Input::get('sport'))) {
                $participant->sports()->sync(array_keys(Input::get('sport')));
            } else {
                $participant->sports()->detach();
            }
//          Message de confirmation si la sauvegarde a réussi
            return Redirect::action('ParticipantsController@edit', $participant->id)->with ( 'status', 'Le partipant ' . $id . ' a été mis a jour!' );
        } else {
            return Redirect::back()->withInput()->withErrors($participant->validationMessages);
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


}
