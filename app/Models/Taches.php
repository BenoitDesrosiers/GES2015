<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taches extends Model
{
	protected $guarded = array('id');

	/** 
	 * Eloquent relationship: un rôle a plusieurs bénévoles 
	 */

	public function benevoles() {
		return $this->hasMany('App\Models\Benevole');
	}
	/**
	 * Validation
	 *
	 * une tâche doit avoir:
	 * - nom: obligatoire, et unique dans toute la table
	 * - Le champ description est falcultatifs.
	 */
	
	protected $fillable = ['nom', 'description'];

	public $validationMessages;

	public function validationRules() {
		return [
			'nom' 		=> 'required',
			];
	}
}
