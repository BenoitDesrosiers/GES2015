<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ArbitreRequest;
use App\Models\DisponibiliteArbitre;
use Carbon\Carbon;
use View;
use Redirect;
use Input;
use DateTime;

use App\Models\Arbitre;
use App\Models\Region;
use App\Models\Sport;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

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
			$sports = Sport::all();

			// La date par défaut du formulaire est <cette année> - 20 ans
			// pour être plus prêt de l'âge moyen attendu
	        $anneeDefaut = date('Y')- 20;
	        $moisDefaut = 0;
	        $jourDefaut = 0;

	        // Remplissage des listes pour les choix de la date de naissance
	        $listeAnnees = ArbitresController::generer_liste(date('Y')-100, 101);
	        $listeMois = ArbitresController::generer_liste(1, 12);
	        $listeJours = ArbitresController::generer_liste(1, 31);

            $listeHeures = ArbitresController::generer_heures(0, 0, 23, 45);

			return View::make('arbitres.create', compact('regions', 'sports', 'listeHeures', 'listeAnnees', 'listeMois', 'listeJours', 'anneeDefaut', 'moisDefaut', 'jourDefaut'));

		} catch (Exception $e) {
            App:abort(404);
        }
	}


	/**
	 * Enregistre dans la bd l'arbitre qui vient d'être créé.
	 *
	 * @return Response
	 */
	public function store(ArbitreRequest $request)
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

            $arbitre->date_naissance = ArbitresController::construire_date($input['annee_naissance']-1, $input['mois_naissance']-1, $input['jour_naissance']-1);
			
			$arbitre->save();

            //Association avec les disponibilités
            $jours = Input::get('jour');
            $mois = Input::get('mois');
            $annees = Input::get('annee');
            $debuts = Input::get('debut');
            $fins = Input::get('fin');
            $commentaires = Input::get('commentaire');

            for ($i=1; $i<= count($jours); $i++){
                /**
                 * S'assure que le champs date est rempli avant de valider car
                 * un arbitre n'est pas obligé des disponibilités. Toutefois,
                 * s'il en a une, les champs doivent être validés.
                 */
                if($jours[$i] != '' || $mois[$i] != '' || $annees[$i] != '') {
                    $disponibilite_arbitre = new DisponibiliteArbitre();

                    $disponibilite_arbitre->date = $this->construire_date($annees[$i], $mois[$i], $jours[$i]);

                    $heuresPossibles = $this->generer_heures(0,0,23,45);
                    $heureDebut = substr($heuresPossibles[$debuts[$i]],0,2);
                    $minutesDebut = substr($heuresPossibles[$debuts[$i]],3);
                    $disponibilite_arbitre->debut = Carbon::createFromTime($heureDebut, $minutesDebut)->format('H:i:s');
                    $heureFin = substr($heuresPossibles[$fins[$i]],0,2);
                    $minutesFin = substr($heuresPossibles[$fins[$i]],3);
                    $disponibilite_arbitre->fin = Carbon::createFromTime($heureFin, $minutesFin)->format('H:i:s');;
                    $disponibilite_arbitre->commentaire = $commentaires[$i];
                    $disponibilite_arbitre->arbitre()->associate($arbitre);
                    if (!$disponibilite_arbitre->save()) {
                        /**
                         * Si la disponibilité n'est pas valide, on détruit
                         * l'arbitre préalablement crée.
                         * Si d'autres disponibilités ont été crées avant, ils sont
                         * détruits par le "cascade" de l'arbitre
                         */
                        $arbitre->delete();
                        return Redirect::back()->withInput()->withErrors($disponibilite_arbitre->validationMessages());
                    }
                }
            }

            // Association avec les sports sélectionnés
            if (is_array(Input::get('sport'))) {
                $arbitre->sports()->sync(array_keys(Input::get('sport')));
            } else {
                $arbitre->sports()->detach();
            }
            return Redirect::action('ArbitresController@create')->with ( 'status', 'L\'arbitre a été créé.' );

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
			return View::make('arbitres.show', compact('arbitre'));

		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}

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
			$sports = Sport::all();
			
			// La date par défaut du formulaire est <cette année> - 20 ans
			// pour être plus prêt de l'âge moyen attendu
	        $anneeDefaut = date('Y')- 20;
	        $moisDefaut = 0;
	        $jourDefaut = 0;

	        // Remplissage des listes pour les choix de la date de naissance
	        $listeAnnees = ArbitresController::generer_liste(date('Y')-100, 101);
	        $listeMois = ArbitresController::generer_liste(1, 12);
	        $listeJours = ArbitresController::generer_liste(1, 31);

            $listeHeures = ArbitresController::generer_heures(0, 0, 23, 45);

            $listeIndexHeuresDebut = array();
            $listeIndexHeuresFin = array();
            $i = 1;
            foreach ($arbitre->disponibiliteArbitre as $disponibilite){
                $heureDebut = substr($disponibilite->debut, 0,2);
                $minutesDebut = substr($disponibilite->debut, 3);

                $listeIndexHeuresDebut[$i] = ($heureDebut * 4) + ($minutesDebut / 15);

                $heureFin = substr($disponibilite->fin, 0,2);
                $minutesFin = substr($disponibilite->fin, 3);
                $listeIndexHeuresFin[$i] = ($heureFin * 4) + ($minutesFin / 15);
                $i++;
            }

	        return View::make('arbitres.edit', compact('arbitre', 'regions', 'sports', 'listeIndexHeuresDebut', 'listeIndexHeuresFin', 'listeHeures','listeAnnees', 'anneeDefaut', 'listeMois', 'listeJours', 'anneeDefaut', 'moisDefaut', 'jourDefaut'));
	    
	    } catch (Exception $e) {
	    	App:abort(404);
	    }
	}


	/**
	 * Mise à jour de l'arbitre dans la bd.
	 *
	 * @param  int $id l'id de l'arbitre à changer.
	 * @return Response
	 */
	public function update(ArbitreRequest $request, $id)
	{
		try {
            DB::beginTransaction();

			$input = Input::all();
			$arbitre = Arbitre::findOrFail($id);

            foreach ($arbitre->disponibiliteArbitre()->get() as $disponibilite){
                $disponibilite->delete();
            }

            $arbitre->prenom = $input['prenom'];
            $arbitre->nom = $input['nom'];
            $arbitre->region_id = $input['region_id'];
            $arbitre->numero_accreditation = $input['numero_accreditation'];
            $arbitre->association = $input['association'];
            $arbitre->numero_telephone = $input['numero_telephone'];
            $arbitre->adresse = $input['adresse'];
            $arbitre->sexe = $input['sexe'];

            $arbitre->date_naissance = ArbitresController::construire_date($input['annee_naissance']-1, $input['mois_naissance']-1, $input['jour_naissance']-1);

            $arbitre->save();

            //Association avec les disponibilités
            $jours = Input::get('jour');
            $mois = Input::get('mois');
            $annees = Input::get('annee');
            $debuts = Input::get('debut');
            $fins = Input::get('fin');
            $commentaires = Input::get('commentaire');

            for ($i=1; $i<= count($jours); $i++){
                /**
                 * S'assure que le champs date est rempli avant de valider car
                 * un arbitre n'est pas obligé des disponibilités. Toutefois,
                 * s'il en a une, les champs doivent être validés.
                 */
                if($jours[$i] != '' || $mois[$i] != '' || $annees[$i] != '') {
                    $disponibilite_arbitre = new DisponibiliteArbitre();

                    $disponibilite_arbitre->date = $this->construire_date($annees[$i], $mois[$i], $jours[$i]);

                    $heuresPossibles = $this->generer_heures(0,0,23,45);
                    $heureDebut = substr($heuresPossibles[$debuts[$i]],0,2);
                    $minutesDebut = substr($heuresPossibles[$debuts[$i]],3);
                    $disponibilite_arbitre->debut = Carbon::createFromTime($heureDebut, $minutesDebut)->format('H:i:s');
                    $heureFin = substr($heuresPossibles[$fins[$i]],0,2);
                    $minutesFin = substr($heuresPossibles[$fins[$i]],3);
                    $disponibilite_arbitre->fin = Carbon::createFromTime($heureFin, $minutesFin)->format('H:i:s');;
                    $disponibilite_arbitre->commentaire = $commentaires[$i];
                    $disponibilite_arbitre->arbitre()->associate($arbitre);
                    if (!$disponibilite_arbitre->save()) {
                        DB::rollback();
                        return Redirect::back()->withInput()->withErrors($disponibilite_arbitre->validationMessages());
                    }
                }
            }

            // Association avec les sports sélectionnés
            if (is_array(Input::get('sport'))) {
                $arbitre->sports()->sync(array_keys(Input::get('sport')));
            } else {
                $arbitre->sports()->detach();
            }
            DB::commit();
            return Redirect::action('ArbitresController@edit', $arbitre->id)->with ( 'status', 'L\'arbitre a été modifié.' );

        } catch (Exception $e) {
            App:abort(404);
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
	//todo: mettre en commun avec ParticipantsController
    private function generer_liste($debut, $n)
    {
        $liste = array();
        $fin = $debut+$n-1;
        for ($i = $debut; $i <= $fin; $i++) {
            $liste[$i+1] = $i;
        }
        return $liste;
    }


	/**
	 * Retourne l'objet Date correspondant aux valeurs passées si elles sont valides
	 * ou le string « invalide » si la date est impossible (ex. 31 février)
	 *
	 * @param  int  $annee L'annee
	 * @param  int  $mois Le mois
	 * @param  int  $jour Le jour
	 * @return Date formée de $annee-$mois-$jour ou « invalide »
	 */
	//todo: mettre en commun avec participantcontroller
	private function construire_date($annee, $mois, $jour) 
	{
		if (checkdate($mois, $jour, $annee)) {
			$dateTest = new DateTime;
			$dateTest->setDate($annee, $mois, $jour);
			return $dateTest;
		} else {
			return "invalide";
		}
	}


    /**
     * Génère une liste d'heures de $nb intervalles de 15min qui part à $heureDebut, $minutesDebut
     *
     * @param $heureDebut       int     L'heure de départ
     * @param $minutesDebut     int     Les minutes de l'heure de départ
     * @param $heureFin         int     L'heure de fin
     * @param $minutesFin       int     Les minutes de l'heure de fin
     * @return array            Liste des heures
     */
    private function generer_heures($heureDebut, $minutesDebut, $heureFin, $minutesFin)
    {
        $liste = array();
        $i = 0;

        while ($heureDebut < $heureFin || $minutesDebut <= $minutesFin){

            $liste[$i] = Carbon::createFromTime($heureDebut, $minutesDebut)->format('H:i');

            if ($minutesDebut == 60){
                $heureDebut++;
                $minutesDebut = 0;
            }

            $minutesDebut = $minutesDebut + 15;
            $i++;
        }
        return $liste;
    }
}
