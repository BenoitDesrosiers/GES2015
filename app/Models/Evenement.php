<?php
/**
 * @author BinarMorker
 * @version 0.0.1 rev 1
 */

namespace App\Models;

class Evenement extends EloquentValidating {
	protected $guarded = array('id');

/** 
 * Eloquent relationship: un événement appartient à une épreuve
 */

public function epreuve() {
	return $this->belongsTo('Epreuve');
}

public function resultats() {
	return $this->hasMany('Resultat');
}
	
/**
 * Validation
 */

public $validationMessages;

public function validationRules() {
	return [
		'nom' => 'required',
		];
}


}