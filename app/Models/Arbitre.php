<?php
/**
 * Un arbitre est une personne associée à une région et à des sports
 * 
 * 
 * @author Sarah Laflamme (modifié par Simon Gagné)
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
	 * Eloquent relationship: un arbitre est associé à plusieurs épreuves
	 */
	public function epreuves() {
		return $this->belongsToMany('App\Models\Epreuve');
	}
	
	
	/**
	 * Eloquent relationship: 
	 * - Un arbitre est associé à plusieurs numéros de téléphone
	 * - Un arbitre est associté à plusieurs adresses courriel
	 */
	public function arbitreTelephone() {
		return $this->hasMany('App\Models\ArbitreTelephone');
	}
	
	public function arbitreCourriel() {
		return $this->hasMany('App\Models\ArbitreCourriel');
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
	        'sexe',
	        'adresse',
	        'date_naissance'
	    ];
		
	/**
	 * Validation
	 *
	 * Un arbitre doit avoir:
	 *  - nom, prenom, region_id, numero_accreditation, association et sexe
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
			'sexe' => 'required|boolean',
			'adresse' => 'string',
			'date_naissance' => 'date'
		];
	}
}