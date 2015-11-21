<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;
use DateTime;
use App;
use App\Models\Region;
use App\Models\Equipe;
use App\Models\Sport;
use App\Models\Participant;
use App\Models\ParticipantEquipe;

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
		$equipes = Equipe::where('equipe','=','1')->get();
		return View::make('equipes.index', compact('equipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = Region::all();
        $sports = Sport::all();
        return View::make('equipes.create', compact('regions', 'sports'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
		$equipe = new Equipe;
		$equipe->equipe = true;
		$equipe->naissance = new DateTime;
		$equipe->nom = Input::get('nom');
		$equipe->numero = Input::get('numero');
		$equipe->region_id = Input::get('region_id');
		$sport = Sport::findOrFail(Input::get('sport'));
		if($equipe->save()) {
			if (Input::has('sport')) {
				$equipe->sports()->sync([$sport->id]);
			} else {
				$equipe->sports()->detach();
			}
// 			Redirection dans la page d'édition de l'équipe
			return Redirect::action('EquipesController@edit', $equipe->id)
				->with ( 'status', 'L\'équipe a été initialisée! Sélectionnez maintenant les joueurs qui en font partie.' );
		} else {
			return Redirect::back()->withInput()->withErrors($equipe->validationMessages());
		}
    }

	/**
	 * Affiche une seule équipe en détail.
	 *
	 * @param  int  $id l'id du chef de l'équipe à afficher
	 * @return Response
	 */
	public function show($id)
	{
		$equipe = Equipe::findOrFail($id);
		$sport = Sport::where('id','=',$equipe->sport_id)->first();
		return View::make('equipes.show', compact('equipe','sport'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//     TODO n'afficher que les joueurs de la même région et qui ont le bon sport
//     	L'équipe à modifier
		$equipe = Equipe::where('equipe','=','1')->where('id','=',$id)->firstOrFail();
// 		Les id des membres actuels de l'équipe
		$membres = $equipe->idMembres();
// 		Les participants susceptibles d'être ajoutés à l'équipe, triés par nom
		$joueurs = Participant::where('equipe','=','0')->orderBy('nom')->orderBy('prenom')->get();
		return View::make('equipes.edit', compact('equipe','joueurs','membres'));
    }

    /**
     * Modifie les joueurs faisant partie de l'équipe
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
		$equipe = Equipe::findOrFail($id);
// 		L'équipe doit être une équipe
		if (!$equipe->equipe) {
			App::abort(404);
		}
		$equipe->equipe = true;
		$equipe->nom = Input::get('nom');
		$equipe->numero = Input::get('numero');

        $membres = Input::get('joueur');
        if ($membres) {
			if (is_array($membres)) {
//      		Les joueurs sélectionnés doivent exister
				$participants = Participant::whereIn('id', $membres);
				if ($participants->count() != count($membres)) {
					App::abort(404);
				}
// 				Les joueurs sélectionnés ne doivent pas être des équipes
				if ($participants->where('equipe','<>','0')->count() > 0) {
					App::abort(404);
				}
			} elseif (Participant::findOrFail($membres)->equipe) {
				App::abort(404);
			}
        }

		if ($equipe->save()) {
// 			Associer les membres de l'équipe
			if ($membres) {
				if (is_array($membres)) {
					$equipe->membres()->sync($membres);
				} else {
					$equipe->membres()->sync([$membres]);
				}
			} else {
				$equipe->membres()->detach();
			}
// 			Redirection dans la page de visualisation de l'équipe
			return Redirect::action('EquipesController@show', $equipe->id);
		} else {
			return Redirect::back()->withInput()->withErrors($equipe->validationMessages());
		}
    }

//     /**
//      * Modifie les joueurs faisant partie de l'équipe
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function update($id)
//     {
// 		$equipe = Equipe::findOrFail($id);
// // 		Le participant-équipe doit être une équipe
// 		if (!$equipe->equipe) {
// 			App::abort(404);
// 		}
// // 		Lecture des joueurs sélectionnés
// 		$joueursActuels = $equipe->idMembres();
//         $membres = Input::get('joueur');
//         $joueursSelectionnes = [];
// 		if (is_array($membres)) {
// 			foreach ($membres as $membre) {
// 				$joueur = Participant::findOrFail($membre);
// // 				Les joueurs ne doivent pas être une équipe
// 				if (!$joueur->equipe) {
// 					$joueursSelectionnes[] = $joueur->id;
// 				}
// 			}
// 		}
// // 		Détermination des membres à retirer de l'équipe
// 		$aEffacer = [];
// 		foreach ($joueursActuels as $joueurActuel) {
// 			if (!in_array($joueurActuel, $joueursSelectionnes)) {
// 				$aEffacer[] = $joueurActuel;
// 			}
// 		}
// // 		Détermination des membres à ajouter à l'équipe
// 		$aAjouter = [];
// 		foreach ($joueursSelectionnes as $joueurSelectionne) {
// 			if (!in_array($joueurSelectionne, $joueursActuels)) {
// 				$aAjouter[] = $joueurSelectionne;
// 			}
// 		}
// // 		Écriture des changements
// 		DB::table('participants_equipes')->where('chef_id','=',$equipe->id)->whereIn('joueur_id', $aEffacer)->delete();
// 		foreach ($aAjouter as $nouveauMembre) {
// 			$participantEquipe = new ParticipantEquipe;
// 			$participantEquipe->chef_id = $equipe->id;
// 			$participantEquipe->joueur_id = $nouveauMembre;
// 			$participantEquipe->save();
// 			return $participantEquipe;
// // 			DB::table('participants_equipes')->insert( ['chef_id' => $equipe->id, 'joueur_id' => $nouveauMembre] );
// 		}
// // 		Visualisation de l'équipe modifiée
// 		return Redirect::action('ParticipantsController@show', $equipe->id)->with ( 'status', 'L\'équipe '.$equipe->prenom.' '.$equipe->nom.' a été mise a jour!' );
//     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$equipe = Equipe::findOrFail($id);
		$equipe->delete();
		return Redirect::action('EquipesController@index');
    }
}
