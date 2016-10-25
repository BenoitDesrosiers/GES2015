<?php
/**
 * La classe Bénévole
 *
 *
 * @author dada
 * @version 0.1
 */

namespace App\Models;

class Benevole extends EloquentValidating {
	protected $guarded = array('id');

	public function disponibilites() {
		return $this->hasMany('App\Models\Disponibilite');
	}
	
	/**
	 * Eloquent relationship: Un bénévole peut avoir entre 0 et plusieurs sports.
	 *
	 * @return Sport[]
	 */
	public function sports() {
		return $this->belongsToMany('App\Models\Sport', 'benevoles_sports', 'benevole_id', 'sport_id');
	}

	/**
	 * Validation
	 *
	 * un bénévole doit avoir:
	 * - nom: obligatoire, string
	 * - adresse : obligatoire, string
	 * - telephone : obligatoire, string
	 * - accreditation : obligatoire, string
	 * - Les périodes de disponibilité et l'accréditation n'est pas
	 *   obligatoire pour l'ajout d'un bénévole.
	 */

	public function validationRules() {
		return [
				'nom' => 'required',
				'prenom' => 'required',
				'adresse' => 'required',
				'numTel' => 'required|string',
				'accreditation' => 'required'
		];
	}
	
}