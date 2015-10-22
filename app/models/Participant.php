<?php
/**
 * un participant est un sportif associé à un ou plusieurs sports et épreuves
 * 
 * Les participants sont associées à un ou plusieurs sports et épreuves. 
 * Deux participants d'un même sport ne peuvent avoir le même nom; mais le même nom peut être utilisé pour 2 sports. 
 * 
 * Exemples des participants: 
 * - pour Atlhétisme
 *   - Cadet féminin 100m 
 * - pour Baseball
 *   - Tournoi masculin
 * 
 * @author BinarMorker
 * @version 0.0.1 rev 1
 */


class Participant extends EloquentValidating {
	protected $guarded = array('id');
	

/** 
 * Eloquent relationship: un participant appartient à un sport
 */
 
public function sports() {
	return $this->belongsToMany('Sport');
}

public function epreuves() {
	return $this->belongsToMany('Epreuve');
}

public function region() {
	return $this->belongsTo('Region');
}
	
/**
 * Validation
 *
 * un participant doit avoir:
 *  - nom: obligatoire, et unique pour un sport donné, mais je n'ai pas trouvé comment exprimer ca avec les règles de Laravel
 *  - Les autres champs sont falcultatifs.
 */

public $validationMessages;

public function validationRules() {
	return [
		'nom' => 'required',
		'prenom' => 'required',
		'numero' => 'required',
		'region_id' => 'required',
		];
}


}