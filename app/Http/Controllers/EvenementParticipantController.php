<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvenementParticipantRequest;
use App\Models\Evenement;
use App\Models\Region;

use View;
use Redirect;
use Input;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class EvenementParticipantController extends Controller
{
    /**
     * Affiche les participants associés à l'épreuve associée à l'événement.
     *
     * @param int $id l'id de l'événement qu'on sélectionne.
     * @return View La vue sportParticipant.index
     */
    public function index($id)
    {
        try {
            $evenement = Evenement::findOrFail($id);
            $participants = $evenement->epreuve->participants->sortBy('region.nom');
            return View::make('evenementParticipant.index', compact('evenement', 'participants'));
        } catch (ModelNotFoundException $e) {
            App::abort(404);
        }
    }

    /**
     * Sauvegarde le lien entre un événement et des participants.
     *
     * @param EvenementParticipantRequest $request  la requête envoyée par la vue.
     * @return View La vue sportParticipant.index
     */
    public function store(EvenementParticipantRequest $request)
    {
        $donnees = $request->all();
        if (isset($donnees['evenement'])) {
            try {
                $evenement = Evenement::findOrFail($donnees['evenement']);
                $participants = $evenement->epreuve->participants->sortBy('region.nom');
                if (isset($donnees['participation'])) {
                    $evenement->participants()->sync(array_keys($donnees['participation']));
                } else {
                    $evenement->participants()->detach();
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
        } else {
            App::abort(404);
        }
        return view('evenementParticipant.index', compact('evenement', 'participants'));
    }
}
