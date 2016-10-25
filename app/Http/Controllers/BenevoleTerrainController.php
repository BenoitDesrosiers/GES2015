<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use View;
use Redirect;
use Input;

use App\Models\Benevole;
use App\Models\Terrain;


use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Le controller pour les bénévoles liés à un terrain.
 * 
 * @author Mathieu
 * @version 0.0.1 rev 1
*/
class BenevoleTerrainController extends BaseController{
    /**
	 * Affiche les bénévoles associés au terrain sélectionné.
	 *
	 * @param[in] int $id l'id du Terrain qu'on sélectionne.
	 */
	public function index($id)
	{
		try{
			$terrain = Terrain::findOrFail($id);
			$benevoles = $terrain->benevoles->sortby('nom');
			return View::make('terrainBenevole.index', compact('benevoles', 'terrain'));
		} catch (ModelNotFoundException $e) {
			App::abort(404);
		}
	}

}
