<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use DateTime;
use App;
use App\Models\Region;
use App\Models\Equipe;
use App\Models\Sport;
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
     * Inscrit une nouvelle équipe dans la table 'participants'
     */
    public function store()
    {
		try {
			$equipe = new Equipe;
			$equipe->equipe = true;
			$equipe->naissance = new DateTime;
			$equipe->nom = Input::get('nom');
			$equipe->numero = Input::get('numero');
			$equipe->region_id = Input::get('region_id');
			
			//une équipe participe à un et un seul sport. Contrairement à un participant qui peut faire plusieurs sports. 
			$sport = Sport::findOrFail(Input::get('sport'));
			if($equipe->save()) {
				if (Input::has('sport')) {
					$equipe->sports()->sync([$sport->id]);
				} else {
					$equipe->sports()->detach();
				}
// 				Redirection dans la page d'édition de l'équipe
				return Redirect::action('EquipesController@edit', $equipe->id)
					->with ( 'status', 'L\'équipe a été initialisée! Sélectionnez maintenant les joueurs qui en font partie.' );
			} else {
				return Redirect::back()->withInput()->withErrors($equipe->validationMessages());
			}
        } catch (Exception $e) {
            App:abort(404);
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
		$equipe = Equipe::findOrFail($id);
		$membres = $equipe->idMembres();
// 		Les participants susceptibles d'être ajoutés à l'équipe, triés par nom
		$joueurs = Participant::where('equipe','=','0')
					->orderBy('nom')->orderBy('prenom')
					->where('region_id','=',$equipe->region_id)
					->join('participant_sport','participants.id','=','participant_sport.participant_id')
					->where('sport_id','=',$equipe->sport()->id)
					->get();
// 		Redirection vers la page d'édition pour permettre d'ajouter des membres
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
		try {
			$equipe = Equipe::findOrFail($id);
// 			L'équipe doit être une équipe
			if (!$equipe->equipe) {
				App::abort(404);
			}
			$equipe->equipe = true;
			$equipe->nom = Input::get('nom');
			$equipe->numero = Input::get('numero');

			$membres = Input::get('joueur');
			if ($membres) {
				if (is_array($membres)) {
//    		  		Les joueurs sélectionnés doivent exister
					$participants = Participant::whereIn('id', $membres);
					if ($participants->count() != count($membres)) {
						App::abort(404);
					}
// 					Les joueurs sélectionnés ne doivent pas être des équipes
					if ($participants->where('equipe','<>','0')->count() > 0) {
						App::abort(404);
					}
				} elseif (Participant::findOrFail($membres)->equipe) {
					App::abort(404);
				}
			}

			if ($equipe->save()) {
// 				Associer les membres à l'équipe
				if ($membres) {
					if (is_array($membres)) {
						$equipe->membres()->sync($membres);
					} else {
						$equipe->membres()->sync([$membres]);
					}
				} else {
					$equipe->membres()->detach();
				}
// 				Redirection dans la page de visualisation de l'équipe
				return Redirect::action('EquipesController@show', $equipe->id);
			} else {
				return Redirect::back()->withInput()->withErrors($equipe->validationMessages());
			}
        } catch (Exception $e) {
            App:abort(404);
        }
    }

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
