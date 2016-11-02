<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use View;
use Redirect;
use Input;
use App;
use DateTime;
use App\Models\Participant;
use App\Models\Region;
use App\Models\Sport;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;

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
	public function index() {
		$routeActionName = 'ParticipantsController@index';
		$participants = Participant::where("equipe","=","false")->get();
		$listeRecherches = ParticipantsController::getListeRecherches();
		$listeFiltres = ParticipantsController::getListeFiltres();
		$valeurFiltre = 0;
		$valeurRecherche = '';
		$infosTri = ParticipantsController::getInfosTri ();
		$participants = ParticipantsController::trierColonnes ( $participants );
		
		return View::make ( 'participants.index', compact ( 'participants', 'routeActionName', 'infosTri', 'listeFiltres', 'listeRecherches', 'valeurFiltre', 'valeurRecherche' ) );
	}

	/**
	 * Créée des participants à partir d'un fichier CSV
	 *
	 * @param Request $request Variable contenant les données envoyées dans le formulaire
	 *
	 * @author ZeLarpMaster
	 * @return Response
	 */
	public function createFromCSV(Request $request) {
		$donnees = array();

		$metadata = array("Nom" => [true, "string", "verifierVariable"], "Prénom" => [true, "string", "verifierVariable"], "Numéro Téléphone" => [false, "string", "verifierVariable"], "Nom Parent" => [false, "string", "verifierVariable"], "Numéro" => [true, 9, "verifierNumero"], "Genre" => [true, true, "verifierGenre"], "Date Naissance" => [true, "string", "verifierDate"], "Adresse" => [false, "string", "verifierVariable"], "Région" => [false, "string", "verifierRegion"], "Sports" => [false, "string", "verifierSport"]);

		$erreurs = null;
		$fichierCsv = $request->file("fichier-csv", null);
		if (is_null($fichierCsv) || !$fichierCsv->isValid()) {
			$donneesCsv = null;
			$plusLongueDonnee = 0;
		} else {
			$donneesCsv = $this->transformerFichierCsv($fichierCsv);
			$plusLongueDonnee = max(max(array_map("count", $donneesCsv)) - count($metadata), 0) + 1;
			$erreurs = $this->verifierDonneesCsv($metadata, $donneesCsv);
		}
		$rowspanEntete = 'colspan="' . strval($plusLongueDonnee) . '"';

		$donnees["entetes"] = $metadata;
		$donnees["rangees"] = $donneesCsv;
		$donnees["rowspanEntete"] = $rowspanEntete;
		$donnees["erreurs"] = $erreurs;

		return View::make("participants.create-batch", $donnees);
	}
	
	/**
	 * Affiche le formulaire de création d'un participant.
	 *
	 * @return Response
	 */
	public function create() {
		$regions = Region::all ();
		$sports = Sport::all ();
		
		// La date par défaut du formulaire est <cette année> - 20 ans
		// pour être plus prêt de l'âge moyen attendu
		$anneeDefaut = date ( 'Y' ) - 20;
		$moisDefaut = 0;
		$jourDefaut = 0;
		
		$listeAnnees = ParticipantsController::generer_liste ( date ( 'Y' ) - 100, 101 );
		$listeMois = ParticipantsController::generer_liste ( 1, 12 );
		$listeJours = ParticipantsController::generer_liste ( 1, 31 );
		return View::make ( 'participants.create', compact ( 'regions', 'sports', 'participantSports', 'listeAnnees', 'anneeDefaut', 'listeMois', 'listeJours', 'anneeDefaut', 'moisDefaut', 'jourDefaut' ) );
	}
	
	/**
	 * Enregistre dans la bd le participant qui vient d'être créé.
	 *
	 * @return Response
	 */
	public function store()
	{
        try {
            $input = Input::all();
            $participant = new Participant;
            $participant->equipe = false;
            $participant->nom = $input['nom'];
            $participant->prenom = $input['prenom'];
            $participant->telephone = $input['telephone'];
            $participant->nom_parent = $input['nom_parent'];
            $participant->numero = $input['numero'];
            $participant->sexe = $input['sexe'];
            $participant->adresse = $input['adresse'];
            $participant->region_id = $input['region_id'];

    //      Création de la date de naissance à partir des valeurs des trois comboboxes
			$anneeNaissance = $input['annee_naissance']-1;
			$moisNaissance = $input['mois_naissance']-1;
			$jourNaissance = $input['jour_naissance']-1;
			if (checkdate($moisNaissance, $jourNaissance, $anneeNaissance)) {
				$dateTest = new DateTime;
				$dateTest->setDate($anneeNaissance, $moisNaissance, $jourNaissance);
				$participant->naissance=$dateTest;
			} else {
				$participant->naissance = "invalide";
			}

            if($participant->save()) {
                if (is_array(Input::get('sport'))) {  //FIXME: si le get plante, le save est déjà fait. 
                    $participant->sports()->sync(array_keys(Input::get('sport')));
                } else {
                    $participant->sports()->detach();
                }
    //          Message de confirmation si la sauvegarde a réussi
                return Redirect::action('ParticipantsController@create')->with ( 'status', 'Le partipant a été créé!' );
            } else {
                return Redirect::back()->withInput()->withErrors($participant->validationMessages());
            }
        } catch (Exception $e) {
            App:abort(404);
        }
	}
	
	/**
	 * Affiche un seul participant.
	 *
	 * @param int $id.
	 *        	L'id du participant à afficher.
	 * @return Response
	 */
	public function show($id) {
		try {
			$participant = Participant::findOrFail($id);
		} catch(ModelNotFoundException $e) {
			App::abort(404);
		}
		return View::make('participants.show', compact('participant'));
	}


    /**
     * Affiche le formulaire pour éditer un participant.
     *
     * @param  int $id l'id du participant à éditer 
     * @return Response
     */
    public function edit($id)
    {
        try {
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
    public static function generer_liste($debut, $n) {
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
        try {
			$input = Input::all();
			$participant = Participant::findOrFail($id);
			$participant->equipe = false;
			$participant->nom = $input['nom'];
			$participant->prenom = $input['prenom'];
			$participant->telephone = $input['telephone'];
			$participant->nom_parent = $input['nom_parent'];
			$participant->numero = $input['numero'];
			$participant->sexe = $input['sexe'];
			$participant->adresse = $input['adresse'];
			$participant->region_id = $input['region_id'];

//      	Création de la date de naissance à partir des valeurs des trois comboboxes
			$anneeNaissance = $input['annee_naissance']-1;
			$moisNaissance = $input['mois_naissance']-1;
			$jourNaissance = $input['jour_naissance']-1;
			if (checkdate($moisNaissance, $jourNaissance, $anneeNaissance)) {
				$dateTest = new DateTime;
				$dateTest->setDate($anneeNaissance, $moisNaissance, $jourNaissance);
				$participant->naissance=$dateTest;
			} else {
// 				Un message d'erreur sera généré lors de la validation
				$participant->naissance = "invalide";
			}

			if($participant->save()) {
				if (is_array(Input::get('sport'))) {
					$participant->sports()->sync(array_keys(Input::get('sport')));
				} else {
					$participant->sports()->detach();
				}
//         		Message de confirmation si la sauvegarde a réussi
				return Redirect::action('ParticipantsController@show', $participant->id)->with ( 'status', 'Le partipant a été mis a jour!' );
			} else {
				return Redirect::back()->withInput()->withErrors($participant->validationMessages());
			}
        } catch (Exception $e) {
            App:abort(404);
        }
    }

	/**
	 * Efface un participant de la bd.
	 *
	 * @param int $id.
	 *        	L'id du participant à effacer.
	 * @return Response
	 */

	public function destroy($id)
	{
		//todo: ajouter le try catch
		$participant = Participant::findOrFail($id);
		$participant->delete();
		return Redirect::action('ParticipantsController@index');
	}
	
	/**
	 * Recherche une entrée de la bd.
	 *
	 * @return Response
	 */
	public function recherche() {
	//TODO: mettre cette logique dans index()
		$routeActionName = 'ParticipantsController@index';
		$listeRecherches = ParticipantsController::getListeRecherches();
		$listeFiltres = ParticipantsController::getListeFiltres();
		$infosTri = ParticipantsController::getInfosTri ();
		$input = Input::all ();
		$valeurFiltre = $input ['listeFiltres'];
		$valeurRecherche = $input ['entreeRecherche'];
		
		if ($valeurRecherche != '') {
			if ($valeurFiltre == 0) {
				$participants = Participant::where ( 'nom', 'like', $valeurRecherche . '%' )->get ();
			} elseif ($valeurFiltre == 1) {
				$participants = Participant::where ( 'prenom', 'like', $valeurRecherche . '%' )->get ();
			} elseif ($valeurFiltre == 2) {
				if (is_numeric($valeurRecherche)) {
					$participants = Participant::where ( 'numero', $valeurRecherche )->get ();
				} else {
					$participants = new \Illuminate\Database\Eloquent\Collection ();
				}
				
			} elseif ($valeurFiltre == 3) {
				$region = Region::where ( 'nom_court', '=', $valeurRecherche )->first ();
				if ($region) {
					$participants = $region->participants()->get();
				} else {
					$participants = new \Illuminate\Database\Eloquent\Collection ();
				}
			} else {
				$participants = Participant::all ();
			}
		} else {
			$participants = Participant::all ();
		}
		
		$participants = ParticipantsController::trierColonnes ( $participants );
		
		return View::make ( 'participants.index', compact ( 'participants', 'routeActionName', 'infosTri', 'listeFiltres', 'listeRecherches', 'valeurFiltre', 'valeurRecherche' ) );
	}

	/**
	 * Transforme un fichier CSV en array
	 *
	 * @param UploadedFile $fichierCsv
	 * 			Fichier CSV à transformer.
	 * @return array $resultat. Tableau des valeurs du $fichierCsv
	 */
	private function transformerFichierCsv($fichierCsv) {
		$contenuBrut = file_get_contents($fichierCsv->getRealPath());
		$contenuCoupe = str_replace("\r", "", $contenuBrut);
		$contenuTableau = array();
		// Sépare les rangées aux nouvelles lignes et enlève la dernière rangée
		foreach(array_slice(explode("\n", $contenuCoupe), 0, -1) as $ligne) {
			$contenuTableau[] = str_getcsv($ligne);
		}
		$resultat = $contenuTableau;
		return $resultat;
	}

	/**
	 * Vérifie les données présentes dans le tableau CSV et retourne les erreurs
	 *
	 * @param array $metadataColonnes La liste de colonnes obligatoires ainsi que leur type
	 * @param array $donneesCsv Le tableau CSV à vérifier
	 *
	 * @author ZeLarpMaster
	 * @return array Une liste d'erreurs par rangée de données CSV
	 */
	private function verifierDonneesCsv($metadataColonnes, $donneesCsv) {
		$resultat = array();
		foreach ($donneesCsv as $cle => $rangee) {
			$erreur = null;
			$colonneMixe = array_map(null, $metadataColonnes, $rangee);
			foreach ($colonneMixe as $colonne) {
				list($metadataValeur, $valeur) = $colonne;
				$valeurVide = !isset($valeur) || trim($valeur) == false;
				if ($valeurVide && $metadataValeur[0]) {
					$erreur = "Valeur obligatoire inexistante";
				} elseif (!is_a($valeur, gettype($metadataValeur[1]))) { // TODO: Fix this line
					$erreur = "Type de la valeur invalide";
				} elseif (!call_user_func($metadataValeur[2], $valeur)) {
					$erreur = "Valeur invalide";
				}
			}
			// Si les données individuelles sont corrects, on regarde le reste.
			if (is_null($erreur)) {
				if ($this->verifierDoublon($rangee)) {
					$erreur = "Existe déjà";
				}
			}
			$resultat[$cle] = $erreur;
		}
		return $resultat;
	}

	/**
	 * Vérifie si la rangée correspond à un participant existant déjà dans la base de données
	 *
	 * @param array $rangee Une rangée de données à vérifier
	 *
	 * @author ZeLarpMaster
	 * @return bool true si le participant existe déjà
	 */
	private function verifierDoublon($rangee) {
		$region = Region::where("upper(nom_court)", "=", strtoupper($rangee[8]))->first();
		$resultat = Participant::where("upper(nom)", "=", strtoupper($rangee[0]))
							->where("upper(prenom)", "=", strtoupper($rangee[1]))
							->where("numero", "=", $rangee[4])
							->where("region_id", "=", $region->id)->exists();
		return $resultat;
	}

	/**
	 * Vérifie si un sport existe
	 *
	 * @param string $sport Le sport à vérifier
	 *
	 * @author ZeLarpMaster
	 * @return bool true si le sport existe
	 */
	private function verifierSport($sport) {
		$resultat = Sport::where("upper(nom)", "=", strtoupper($sport))->exists();
		return $resultat;
	}

	/**
	 * Vérifie si une région existe
	 *
	 * @param string $region La région à vérifier
	 *
	 * @author ZeLarpMaster
	 * @return bool true si la région existe
	 */
	private function verifierRegion($region) {
		$resultat = Region::where("upper(nom_court)", "=", strtoupper($region))->exists();
		return $resultat;
	}

	/**
	 * Vérifie si une date est valide
	 * La date doit être écrite dans une string suivant le format Québécois: JJ-MM-AAAA
	 *
	 * @param string $date La date à vérifier
	 *
	 * @author ZeLarpMaster
	 * @return bool true si la date est invalide
	 */
	private function verifierDate($date) {
		$date_explosee = explode("-", $date, 2);
		if ($date_explosee !== false && count($date_explosee) == 3) {
			list($jour, $mois, $annee) = $date_explosee;
			$resultat = checkdate($mois, $jour, $annee);
		} else {
			$resultat = false;
		}
		return $resultat;
	}

	/**
	 * Vérifie si un numéro est invalide
	 *
	 * @param string $numero Le numéro à vérifier
	 *
	 * @author ZeLarpMaster
	 * @return bool true si le numéro est invalide
	 */
	private function verifierNumero($numero) {
		$resultat = !ctype_digit($numero);
		return $resultat;
	}

	/**
	 * Vérifie si la variable est une chaîne de caractères
	 *
	 * @param string $variable La variable à vérifier
	 *
	 * @author ZeLarpMaster
	 * @return bool true si l'argument n'est pas une chaîne de caractères
	 */
	private function verifierVariable($variable) {
		$resultat = !is_string($variable);
		return $resultat;
	}

	/**
	 * Vérifie si le genre est valide
	 *
	 * @param string $genre Le genre à vérifier
	 *
	 * @author ZeLarpMaster
	 * @return bool true si le genre n'est pas "1" ou "0"
	 */
	private function verifierGenre($genre) {
		$resultat = !($genre == "1" || $genre == "0");
		return $resultat;
	}

	/**
	 * Trie une collection.
	 *
	 * @param Collection $collectionNonTriee.
	 *        	Collection à trier selon le paramètre de tri et la direction.
	 * @return Collection $collectionTriee. Collection trier selon le paramètre de tri et la direction.
	 */
	private function trierColonnes($collectionNonTriee) {
		// Paramêtres récupérés dans le liens du titre de la colonne sélectionnée.
		$parametreDeTri = Input::get ( 'parametreDeTri' );
		$direction = Input::get ( 'direction' );
		
		if ($direction == 'desc') {
			$collectionTriee = $collectionNonTriee->sortByDesc ( $parametreDeTri );
		} else {
			$collectionTriee = $collectionNonTriee->sortBy ( $parametreDeTri );
		}
		
		return $collectionTriee;
	}
	
	/**
	 * Retourne les informations de tri.
	 *
	 * @return Array $infosTri. Contient les informations de tri.
	 */
	private function getInfosTri() {
		$parametreDeTri = Input::get ( 'parametreDeTri' );
		$direction = Input::get ( 'direction' );
		$infosTri = [ 
				'nom' => [ 
						'texteAffiche' => 'Nom, Prenom',
						'trie' => [ 
								'parametreDeTri' => 'nom',
								'direction' => 'asc' 
						] 
				],
				'numero' => [ 
						'texteAffiche' => 'Numéro',
						'trie' => [ 
								'parametreDeTri' => 'numero',
								'direction' => 'asc' 
						] 
				],
				'region_id' => [ 
						'texteAffiche' => 'Région',
						'trie' => [ 
								'parametreDeTri' => 'region_id',
								'direction' => 'asc' 
						] 
				]
		];
		
		if ($parametreDeTri) {
			if ($direction == 'asc') {
				$infosTri [$parametreDeTri] ['trie'] ['direction'] = 'desc';
			} else {
				$infosTri [$parametreDeTri] ['trie'] ['direction'] = 'asc';
			}
		}
		
		return $infosTri;
	}
	
	/**
	 * Retourne la liste des noms courts de tous les régions.
	 * 
	 * @return Array $listeRecherches. Contient les noms courts des régions.
	 */
	 //TODO: renommer cette fonction getRegions
	private function getListeRecherches() {
		$regions = Region::all('nom_court');
		$listeRecherches = [];
		foreach ($regions as $region){
			array_push($listeRecherches, $region->nom_court);
		}
		return $listeRecherches;
	}
	
	private function getListeFiltres(){
		$listeFiltres = [ 
				'Nom',
				'Prénom',
				'Numéro',
				'Région'
		];
		return $listeFiltres;
	}
}
