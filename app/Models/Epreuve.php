<?php
/**
 * Une Epreuve est une compétition associée à un sport
 * 
 * Les épreuves sont associées à un seul sport. 
 * Deux épreuves d'un même sport ne peuvent avoir le même nom; mais le même nom peut être utilisé pour 2 sports. 
 * 
 * Exemples d'épreuves: 
 * - pour Atlhétisme
 *   - Cadet féminin 100m 
 * - pour Baseball
 *   - Tournoi masculin
 * 
 * @author benou
 * @version 0.1
 */

namespace App\Models;

class Epreuve extends EloquentValidating {
	protected $guarded = array('id');

/** 
 * Eloquent relationship: une épreuve appartient à un sport
 */

public function sport() {
	return $this->belongsTo('Sport');
}

public function evenements() {
	return $this->hasMany('Evenement');
}
	
public function participants() {
	return $this->belongsToMany('Participant');
}
	
/**
 * Validation
 *
 * une épreuve doit avoir:
 *  - nom: obligatoire, et unique pour un sport donné, mais je n'ai pas trouvé comment exprimer ca avec les règles de Laravel
 *  - Les autres champs sont falcultatifs.
 */

public $validationMessages;

public function validationRules() {
	return [
		'nom' => 'required',
		];
}


}