<?php
/**
 * Un arbitre est une personne associée à une région et à des sports
 * 
 * 
 * @author Sarah Laflamme
 * @version 0.0.1 rev 1
 */

namespace App\Models;

class Arbitre extends EloquentValidating {
	protected $guarded = array('id');

	/** 
	 * Eloquent relationship: 
	 * - Un arbitre est associé à une région
	 * - Un arbitre est associé à un ou plusieurs sports
	 */
	
	public function region() {
		return $this->belongsTo('App\Models\Region');
	}

	public function sports() {
		return $this->belongsToMany('App\Models\Sport', 'arbitres_sports', 'arbitre_id', 'sport_id');
	}

	/**
	 * Identifie les colonnes qui peuvent être modifiées
	 */
	protected $fillable = [
	        'nom',
	        'prenom',
	        'region_id',
	        'numero_accreditation',
	        'association',
	        'numero_telephone',
	        'sexe',
	        'adresse',
	        'date_naissance'
	    ];
		
	/**
	 * Validation
	 *
	 * Un arbitre doit avoir:
	 *  - nom, prenom, region_id, numero_accreditation, association, numero_telephone et sexe
	 *  - Les autres champs sont falcultatifs.
	 */

	public $validationMessages;

	public function validationRules() {
		return [
			'nom' => 'required|string',
			'prenom' => 'required|string',
			'region_id' => 'required|integer',
			'numero_accreditation' => 'required|string',
			'association' => 'required|string',
			'numero_telephone' => 'required|string',
			'sexe' => 'required|boolean',
			'adresse' => 'string',
			'date_naissance' => 'date'
		];
	}
}