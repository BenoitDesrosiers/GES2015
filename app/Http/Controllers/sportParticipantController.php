<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
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
 * @author Mathieu
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
			$participants = $sport->participants->sortby('nom');
			return View::make('sportParticipant.index', compact('regions', 'participants', 'sport'));
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
	}

}