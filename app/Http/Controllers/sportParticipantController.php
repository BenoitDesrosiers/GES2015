<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
 * @version 2.0.2
 * @modified 20161101
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
     * Exclue les équipes des participants retournés.
     * @param Request $request L'id d'un région.
     * @return mixed $participants La liste des participants selon une région.
     */
    public function listerParticipants(Request $request)
    {
        if ($request->ajax())
        {
            $region_id = $request->input('region_id');
            if ( isset($region_id) )
            {
                return Participant::with('sports')
                    ->where('region_id', $region_id)
                    ->where('equipe', 0)
                    ->orderBy('nom')
                    ->get();
            }
        }
        App::abort(403);
    }

    /**
     * Sauvegarde le lien entre un sport et des participants.
     * @return View La vue sportParticipant.index
     */
    public function store()
    {
        $infos = Input::all();
        $regions = Region::all()->sortBy('nom');
        if (isset($infos['region_id'], $infos['sport']))
        {
            try {
                $sport = Sport::findOrFail($infos['sport']);
                $participants = Participant::where('region_id', $infos['region_id'])->get();

                // Pas efficace de toute les enlever et remettre ceux necessaire, mais la fonction sync, qui permetterait
                // ça, a besoin de l'id de tous les participants pour le sport, cependant j'ai seulement ceux selon une région.
                foreach ($participants as $participant)
                {
                    $sport->participants()->detach($participant->id);
                }

                if (isset($infos['participation']))
                {
                    foreach ($infos['participation'] as $key => $value)
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
        return view('sportParticipant.index', ['sport'=>$sport, 'regions'=>$regions, 'region_id'=>$infos["region_id"]]);
    }
}
