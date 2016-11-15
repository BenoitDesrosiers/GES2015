<?php
/**
 * La classe Sport
*
*
* @author benou
* @version 0.1
*/

namespace App\Models;

class Sport extends EloquentValidating {
	protected $guarded = array('id');


	/**
	 * Eloquent relationship: un sport a plusieurs épreuves
	 */
	public function terrains() {
		return $this->belongsToMany('App\Models\Terrain');
	}

	public function epreuves() {
		return $this->hasMany('App\Models\Epreuve');
	}

	public function participants() {
		return $this->belongsToMany('App\Models\Participant');
	}
	
	/**
	 * Eloquent relationship: Un sport peut avoir de 0 à plusieurs bénévoles.
	 *
	 * @return Benevole[]
	 */
	public function benevoles() {
		return $this->belongsToMany('App\Models\Benevole');
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