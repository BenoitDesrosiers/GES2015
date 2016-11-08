<?php
/**
 * ArbitreCourriel est une adresse courriel associée à un arbitre
 * 
 * 
 * @author Simon Gagné
 * @version 0.0.1 rev 1
 */

namespace App\Models;

class ArbitreCourriel extends EloquentValidating {
	protected $guarded = array('id');
	
	protected $table = 'arbitre_courriel';

	/** 
	 * Eloquent relationship: 
	 * - Un courriel est associé à un arbitre
	 */

	public function arbitre() {
		return $this->belongsTo('App\Models\Arbitre');
	}


	/**
	 * Identifie les colonnes qui peuvent être modifiées
	 */
	protected $fillable = [
	        'courriel',
	        'description'
	    ];
		
	/**
	 * Validation
	 *
	 * Un arbitreCourriel doit obligatoirement avoir:
	 *  - courriel :string
	 * 
	 * Un arbitreCourriel peut facultativement avoir:
	 *  - description :string
	 */

	public $validationMessages;

	public function validationRules() {
		return [
			'courriel' => 'required|string',
			'description' => 'string',
		];
	}
}