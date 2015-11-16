<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;
use App;
use App\Models\Equipe;
use App\Models\Participant;

/**
 * Le controlleur pour les équipes
 *
 * @author obnosim
 */

class EquipesController extends Controller
{
    /**
     * Liste toutes les équipes ainsi que leurs membres
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
    {
		$equipes = Participant::where('equipe','=','1')->get();
		return View::make('equipes.index', compact('equipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

	/**
	 * Affiche une seule équipe en détail.
	 *
	 * @param  int  $id l'id du chef de l'équipe à afficher
	 * @return Response
	 */
	public function show($id)
	{
		return ParticipantsController::show($id);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//     	L'équipe à modifier
		$chef = Participant::findOrFail($id);
// 		Les participants susceptibles d'être ajoutés à l'équipe, triés par nom
		$joueursTries = DB::table('participants')->where('equipe','=','0')->orderBy('nom')->orderBy('prenom')->get();
		$joueurs = array();
		foreach ($joueursTries as $joueur) {
			$joueurs[] = Participant::findOrFail($joueur->id);
		}
		$membres = $chef->idMembres();
		return View::make('equipes.edit', compact('chef','joueurs','membres'));
    }

    /**
     * Modifie les joueurs faisant partie de l'équipe
     * Comme il s'agit d'une sélection parmi des valeurs déterminées par EquipesControlleur::edit(),
     * les erreurs ne peuvent provenir que d'un hack du formulaire: il n'y a donc pas de messages d'erreur
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
		$chef = Participant::findOrFail($id);
// 		Le participant-équipe doit être une équipe
		if (!$chef->equipe) {
			App::abort(404);
		}
// 		Lecture des joueurs sélectionnés
		$joueursActuels = $chef->idMembres();
        $membres = Input::get('joueur');
        $joueursSelectionnes = [];
		if (is_array($membres)) {
			foreach ($membres as $membre) {
				$joueur = Participant::findOrFail($membre);
// 				Les participants-joueurs ne doivent pas être une équipe
				if ($joueur->equipe) {
					App::abort(404);
				} else {
					$joueursSelectionnes[] = $joueur->id;
				}
			}
		}
// 		Détermination des membres à retirer de l'équipe
		$aEffacer = [];
		foreach ($joueursActuels as $joueurActuel) {
			if (!in_array($joueurActuel, $joueursSelectionnes)) {
				$aEffacer[] = $joueurActuel;
			}
		}
// 		Détermination des membres à ajouter à l'équipe
		$aAjouter = [];
		foreach ($joueursSelectionnes as $joueurSelectionne) {
			if (!in_array($joueurSelectionne, $joueursActuels)) {
				$aAjouter[] = $joueurSelectionne;
			}
		}
// 		Écriture des changements
		DB::table('participants_equipes')->where('chef_id','=',$chef->id)->whereIn('joueur_id', $aEffacer)->delete();
		foreach ($aAjouter as $nouveauMembre) {
			DB::table('participants_equipes')->insert( ['chef_id' => $chef->id, 'joueur_id' => $nouveauMembre] );
		}
// 		Visualisation de l'équipe modifiée
		return Redirect::action('ParticipantsController@show', $chef->id)->with ( 'status', 'L\'équipe '.$chef->prenom.' '.$chef->nom.' a été mise a jour!' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($chef_id, $joueur_id)
    {
        //
    }
}
