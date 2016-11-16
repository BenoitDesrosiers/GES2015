<?php
/**
 * Le controller pour afficher les arbitres dans le sport.
 * 
 * @author Francis M
 * @version 0.1
 */
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;

use App\Models\Arbitre;
use App\Models\Sport;

use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les arbitres liés à un sport.
 * 
 * @author Francis
 * @version 0.0.1
*/
class SportsArbitresController extends BaseController{
    /**
	 * Affiche les arbitres associés au sport sélectionné.
	 *
	 * @param $sport = Sport::findOrFail($id); l'id de l'arbitre qu'on sélectionne. <<< c'est quoi ce commentaire???
	 */
	public function index($id)
	{
		try{
			$sport = Sport::findOrFail($id);
			$arbitresSports = $sport->arbitres->sortby('nom');
			return View::make('sportArbitre.index', compact('sport', 'arbitresSports'));
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
	}

}
