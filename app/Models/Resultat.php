<?php
/**
 * @author BinarMorker
 * @version 0.0.1 rev 1
 */
class Resultat extends EloquentValidating {
	protected $guarded = array('id');
	protected $table = 'resultats_tournois';

/** 
 * Eloquent relationship: un événement appartient à une épreuve
 */

public function evenement() {
	return $this->belongsTo('Evenement');
}
	
/**
 * Validation
 */

public $validationMessages;

public function validationRules() {
	return [
		'participant1_id' => 'required',
		'participant2_id' => 'required',
		];
}


}