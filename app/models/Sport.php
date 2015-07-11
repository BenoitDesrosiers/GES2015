<?php
/**
 * La classe Sport
 * 
 * 
 * @author benou
 * @version 0.1
 */
class Sport extends EloquentValidating {
	protected $guarded = array('id');


	/**
	 * Eloquent relationship: un sport a plusieurs épreuves
	 */ 
	public function epreuves() {
		return $this->hasMany('Epreuve');
	}
	
	public function participants() {
		return $this->belongsToMany('Participant');
	}
	

/**
 * Validation
 *
 * un sport doit avoir:
 * - nom: obligatoire, et unique dans toute la table
 * - saison : obligatoire, e (été), ou h (hiver)
 * - tournoi : obligatoire, booléen
 * - Les autres champs sont falcultatifs.
 */

public function validationRules() {
	return [
		'nom' => 'required|unique:sports,nom'.($this->id ? ",$this->id" : ''),
 		'saison' => 'in:e,h',
		'tournoi' => 'required|boolean'
		];
}

}