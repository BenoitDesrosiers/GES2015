<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use View;
use Redirect;
use Input;

use App\Models\Participant;
use App\Models\Region;
use App\Models\Sport;


use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les participants liés à un sport.
 * 
 * @author Mathieu & Alexandre
 * @version 0.0.1 rev 1
*/
class sportParticipantController extends BaseController{
    /**
	 * Affiche les participants associés au sport sélectionné par région.
	 *
	 * @param[in] int $id l'id du sport qu'on sélectionne.
	 */
	public function index($id)
	{
		try{
			$sport = Sport::findOrFail($id);
			$regions = Region::all()->sortby('nom');
            return View::make('sportParticipant.index', compact('regions', 'sport', 'regionChoisie'));

		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
	}

    /**
     * liste les participants d'une région.
     * Exclue les équipes.
     * @param Request $request
     * @return mixed $participants
     */
    public function listerParticipants(Request $request)
    {
        $region_id = $request->input('region_id');
        if ( isset($region_id) )
        {
            $participants = Participant::with('sports')
                ->where('region_id', $region_id)
                ->where('equipe', 0)
                ->orderBy('nom')
                ->get();
            return $participants;
        }
        else
        {
            App::abort(404);
        }
    }

    /**
     * Sauvegarde le lien entre un sport et des participants.
     * @return View sportParticipant.index
     */
    public function store()
    {
        $region_id = Input::get('region');
        $sport_id = Input::get('sport');
        $participation = Input::get('participation');
        $regions = Region::all()->sortBy('nom');
        if (isset($region_id, $sport_id))
        {
            try {
                $sport = Sport::findOrFail($sport_id);
                $participants = Participant::where('region_id', $region_id)->get();

                // Pas efficace de toute les enlever et remettre ceux necessaire, mais la fonction sync, qui permetterait
                // ça, a besoin de l'id de tous les participants pour le sport, cependant j'ai seulement ceux selon une région.
                foreach ($participants as $participant)
                {
                    $sport->participants()->detach($participant->id);
                }

                if (count($participation) > 0)
                {
                    foreach ($participation as $key => $value)
                    {
                        if ($value)
                        {
                            $sport->participants()->attach($key);
                        }
                    }
                }

                session()->flash('alert-success','Sauvegarde réussie!');

            }
            catch(ModelNotFoundException $e)
            {
                App::abort(404);
            }
            catch(QueryException $e)
            {
                session()->flash('alert-danger','Sauvegarde râté...');
            }
        }
        else
        {
            App::abort(404);
        }

        return view('sportParticipant.index', compact('sport', 'regions', 'region_id'));
    }
}
