<?php
/**
 * une region est un sportif associé à un ou plusieurs sports et épreuves
 * 
 * Les regions sont associées à un ou plusieurs sports et épreuves. 
 * Deux regions d'un même sport ne peuvent avoir le même nom; mais le même nom peut être utilisé pour 2 sports. 
 * 
 * Exemples des regions: 
 * - pour Atlhétisme
 *   - Cadet féminin 100m 
 * - pour Baseball
 *   - Tournoi masculin
 * 
 * @author BinarMorker
 * @version 0.0.1 rev 1
 */

namespace App\Models;

class Region extends EloquentValidating {
	protected $guarded = array('id');

/** 
 * Eloquent relationship: une region appartient à un sport
 */

public function participants() {
	return $this->hasMany('App\Models\Participant');
}
	
/**
 * Validation
 *
 * une region doit avoir:
 *  - nom: obligatoire, et unique pour un sport donné, mais je n'ai pas trouvé comment exprimer ca avec les règles de Laravel
 *  - Les autres champs sont falcultatifs.
 */

public $validationMessages;

public function validationRules() {
	return [
		'nom' => 'required',
		'nom_court' => 'required',
		];
}


}