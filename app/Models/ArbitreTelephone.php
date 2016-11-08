<?php
/**
 * ArbitreTelephone est un téléphone associé à un arbitre
 * 
 * 
 * @author Simon Gagné
 * @version 0.0.1 rev 1
 */

namespace App\Models;

class ArbitreTelephone extends EloquentValidating {
	protected $guarded = array('id');
	
	protected $table = 'arbitre_telephone';

	/** 
	 * Eloquent relationship: 
	 * - Un téléphone est associé à un arbitre
	 */

	public function arbitre() {
		return $this->belongsTo('App\Models\Arbitre');
	}


	/**
	 * Identifie les colonnes qui peuvent être modifiées
	 */
	protected $fillable = [
	        'numero_telephone',
	        'description'
	    ];
		
	/**
	 * Validation
	 *
	 * Un arbitreTelephone doit obligatoirement avoir:
	 *  - numero_telephone :string
	 *  
	 * Un arbitreTelephone peut facultativement avoir
	 *  - description:string
	 */

	public $validationMessages;

	public function validationRules() {
		return [
			'numero_telephone' => 'required|string',
			'description' => 'string',
		];
	}
}