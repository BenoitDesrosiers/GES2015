<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\DelegueCourriel;
use App\Models\DelegueTelephone;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use View;
use Redirect;
use Input;
use DateTime;

use App\Models\Delegue;
use App\Models\Region;
use App\Models\Role;

use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les délégués.
 * 
 * @author SteveL
 * @version 0.1
 */
class DeleguesController extends BaseController {

	/**
	 * Affiche une liste de délégués.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			$delegues = Delegue::all()->sortby('nom');
			return View::make('delegues.index', compact('delegues'));
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
	}


	/**
	 * Affiche le formulaire de création de la ressource.
	 *
	 * @return Response
	 */
	public function create()
	{
		try {
			
			$regions = Region::all();
            $telephones = array();
			$roles = Role::all();
			//      La date par défaut du formulaire est <cette année> - 20 ans
			//      pour être plus prêt de l'âge moyen attendu
			$anneeDefaut = date('Y')- 20;
			$moisDefaut = 0;
			$jourDefaut = 0;
			$listeAnnees = ParticipantsController::generer_liste(date('Y')-100, 101); //FIXME: les délégués ne devraient pas être dépendant des Participants. Mettre cette fonction dans un helper. 
			$listeMois = ParticipantsController::generer_liste(1, 12);
			$listeJours = ParticipantsController::generer_liste(1, 31);
			return View::make('delegues.create', compact('regions', 'telephones', 'roles', 'listeAnnees', 'anneeDefaut', 'listeMois', 'listeJours', 'anneeDefaut', 'moisDefaut', 'jourDefaut'));
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
	}


	/**
	 * Enregistre dans la bd la ressource qui vient d'être créée.
     *
     * @author Steve L, Marc P
     *
     * @return Response
    */
    public function store()
    {
        try {
            $input = Input::all();
            $delegue = new Delegue;
            $delegue->nom = $input['nom'];
            $delegue->prenom = $input['prenom'];
            $delegue->region_id = $input['region_id'];
            $roles = Input::get('role');
            //      Le champ 'accreditation' n'est pas transmis s'il n'est pas coché, il faut vérifier autrement.
            if(Input::has('accreditation')) {
                $delegue->accreditation = true;
            } else {
                $delegue->accreditation = false;
            }
            $delegue->sexe = $input['sexe'];

            //      Création de la date de naissance à partir des valeurs des trois comboboxes
            $anneeNaissance = $input['annee_naissance']-1;
            $moisNaissance = $input['mois_naissance']-1;
            $jourNaissance = $input['jour_naissance']-1;
            if (checkdate($moisNaissance, $jourNaissance, $anneeNaissance)) {
                $dateTest = new DateTime;
                $dateTest->setDate($anneeNaissance, $moisNaissance, $jourNaissance);
                $delegue->date_naissance=$dateTest;
            } else {
                $delegue->date_naissance = "invalide";
            }
            $delegue->adresse = $input['adresse'];

            if($delegue->save()) {
                //		Associer les téléphones au délégué.
                $telephones = Input::get('telephone');
                foreach($telephones as $telephone) {
                    $objet_telephone = New DelegueTelephone();
                    $objet_telephone->telephone = $telephone;
                    $objet_telephone->delegue()->associate($delegue);
                    $objet_telephone->save();
                }
                //		Associer les courriels au délégué.
                $courriels = Input::get('courriel');
                foreach($courriels as $courriel) {
                    $objet_courriel = New DelegueCourriel();
                    $objet_courriel->courriel = $courriel;
                    $objet_courriel->delegue()->associate($delegue);
                    $objet_courriel->save();
                }
                //		Associer les rôles au délégué.
                if ($roles) {
                    if (is_array($roles)) {
                        $delegue->roles()->sync($roles);
                    } else {
                        $delegue->roles()->sync([$roles]);
                    }
                } else {
                    $delegue->roles()->detach();
                }
                return Redirect::action('DeleguesController@index');
            } else {
                return Redirect::back()->withInput()->withErrors($delegue->validationMessages());
            }
        } catch(ModelNotFoundException $e) {
            App::abort(404);
        }
    }


	/**
	 * Affiche la ressource.
	 *
	 * @param  int  $id l'id du rôle à afficher
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$delegue = Delegue::findOrFail($id);
			$region = Region::findOrFail($delegue->region_id);
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('delegues.show', compact('delegue','region'));
	}


	/**
	 * Affiche le formulaire pour éditer la ressource.
	 *
	 * @param  int  $id l'id du rôle à éditer 
	 * @return Response
	 */
	public function edit($id)
	{
		try {
			$delegue = Delegue::findOrFail($id);
			$regions = Region::all();
			$roles = Role::all();
			$postes = $delegue->idRoles();
			//      Si de vieilles entrées n'ont pas de date de naissance, on utilise les valeurs par défaut
			$anneeDefaut = date('Y')- 20;
			$moisDefaut = 0;
			$jourDefaut = 0;
			if ($delegue->date_naissance) {
				//  Déterminer les valeurs des trois comboboxes pour la date de naissance.
				$stringsDate = explode('-',$delegue->date_naissance);
				$anneeDefaut = $stringsDate[0]+1;
				$moisDefaut = $stringsDate[1]+1;
				$jourDefaut = $stringsDate[2]+1;
			}
			//      Générer les listes des comboboxes pour la date de naissance.
			$listeAnnees = ParticipantsController::generer_liste(date('Y')-100, 101);
			$listeMois = ParticipantsController::generer_liste(1, 12);
			$listeJours = ParticipantsController::generer_liste(1, 31);
			return View::make('delegues.edit', compact('delegue', 'regions', 'roles', 'postes', 'listeAnnees', 'anneeDefaut', 'listeMois', 'listeJours', 'anneeDefaut', 'moisDefaut', 'jourDefaut'));
        } catch (Exception $e) {
            App:abort(404);
        }
	}


	/**
	 * Mise à jour de la ressource dans la bd.
     *
     * @author Steve L, Marc P
	 *
	 * @param  int  $id l'id du rôle à changer.
	 * @return Response
	 */
	public function update($id)
	{
		try {
            DB::beginTransaction();
            $input = Input::all();
		    $ancien_delegue = Delegue::findOrFail($id);
            foreach ($ancien_delegue->telephones()->get() as $telephone)
            {
                $telephone->delete();
            }
            foreach ($ancien_delegue->courriels()->get() as $courriel)
            {
                $courriel->delete();
            }
            $this->destroy($id);
            $delegue = new Delegue;
            $delegue->nom = $input['nom'];
			$delegue->prenom = $input['prenom'];
            $delegue->region_id = $input['region_id'];
			$roles = Input::get('role');
			
			//      Le champ 'accreditation' n'est pas transmis s'il n'est pas coché, il faut vérifier autrement.
            if(Input::has('accreditation')) {
                $delegue->accreditation = true;
            } else {
                $delegue->accreditation = false;
            }
			$delegue->sexe = $input['sexe'];
			
			//      Création de la date de naissance à partir des valeurs des trois comboboxes
			$anneeNaissance = $input['annee_naissance']-1;
			$moisNaissance = $input['mois_naissance']-1;
			$jourNaissance = $input['jour_naissance']-1;
			if (checkdate($moisNaissance, $jourNaissance, $anneeNaissance)) {
				$dateTest = new DateTime;
				$dateTest->setDate($anneeNaissance, $moisNaissance, $jourNaissance);
				$delegue->date_naissance=$dateTest;
			} else {
				$delegue->date_naissance = "invalide";
			}
			$delegue->adresse = $input['adresse'];

			if($delegue->save())
			{
                //		Associer les téléphones au délégué.
                $telephones = Input::get('telephone');
                foreach($telephones as $telephone) {
                    $objet_telephone = New DelegueTelephone();
                    $objet_telephone->telephone = $telephone;
                    $objet_telephone->delegue()->associate($delegue);
                    $objet_telephone->save();
                }
                //		Associer les courriels au délégué.
                $courriels = Input::get('courriel');
                foreach($courriels as $courriel) {
                    $objet_courriel = New DelegueCourriel();
                    $objet_courriel->courriel = $courriel;
                    $objet_courriel->delegue()->associate($delegue);
                    $objet_courriel->save();
                }
			    //		Associer les rôles au délégué
				if ($roles) {
					if (is_array($roles)) {
						$delegue->roles()->sync($roles);
					} else {
						$delegue->roles()->sync([$roles]);
					}
				} else {
					$delegue->roles()->detach();
				}
                DB::commit();
				return Redirect::action('DeleguesController@index');
			} else {
                DB::rollBack();
			    return Redirect::back()->withInput()->withErrors($delegue->validationMessages());
			}
		} catch(ModelNotFoundException $e) {
            DB::rollBack();
			App::abort(404);
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
		try {
			$delegue = Delegue::findOrFail($id);
			$delegue->delete();
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return Redirect::action('DeleguesController@index');
	
	}
}
