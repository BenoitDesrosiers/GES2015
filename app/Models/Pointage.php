<?php
/**
 * La classe Pointage
 *
 *
 * @author Alexandre Girardin
 * @version 0.1
 */

namespace App\Models;

class Pointage extends EloquentValidating {
	protected $guarded = array('id');
	
	/**
	 * Eloquent relationship: Une table de pointage appartient à un sport
	 */
	public function sport() {
		return $this->belongsTo('App\Models\Sport');
	}
	
	/**
	 * Identifie les colonnes qui peuvent être modifiées
	 */
	protected $fillable = [
			'sport_id',
			'position',
			'valeur'
	];
	
	public $validationMessages;

	/**
	 * Validation
	 *
	 * Un pointage doit avoir:
	 * - sportId: obligatoire, integer
	 * - position : obligatoire, integer
	 * - pointage : obligatoire, integer
	 */
	public function validationRules() {
		return [
				'sport_id' => 'required|integer|exists:sports,id',
				'position' => 'required|integer|min:0',
				'valeur' => 'required|integer|between:0,100'
		];
	}

}