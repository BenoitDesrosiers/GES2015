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
	 * Eloquent relationship: un arbitre est associé à plusieurs épreuves
	 */
	public function epreuves() {
		return $this->belongsToMany('App\Models\Epreuve');
	}

    /**
     * Eloquent relationship: un arbitre est associé à plusieurs disponibilités
     */
    public function disponibiliteArbitre() {
        return $this->hasMany('App\Models\DisponibiliteArbitre');
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
}