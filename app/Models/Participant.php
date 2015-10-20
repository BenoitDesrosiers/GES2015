<?php
/**
 * un participant est un sportif associé à un ou plusieurs sports et épreuves
 * 
 * Les participants sont associées à un ou plusieurs sports et épreuves. 
 * Deux participants d'un même sport ne peuvent avoir le même nom; mais le même nom peut être utilisé pour 2 sports. 
 * 
 * Exemples des participants: 
 * - pour Atlhétisme
 *   - Cadet féminin 100m 
 * - pour Baseball
 *   - Tournoi masculin
 * 
 * @author BinarMorker
 * @version 0.0.1 rev 1
 */
class Participant extends EloquentValidating {
	protected $guarded = array('id');

/** 
 * Eloquent relationship: un participant appartient à un sport
 */

public function sports() {
	return $this->belongsToMany('Sport');
}

public function epreuves() {
	return $this->belongsToMany('Epreuve');
}

public function region() {
	return $this->belongsTo('Region');
}

/**
 * Identifie les colonnes qui peuvent être modifiées
 */
protected $fillable = [
        'equipe',
        'nom',
        'prenom',
        'telephone',
        'nom_parent',
        'numero',
        'sexe',
        'naissance',
        'adresse',
        'region_id'
    ];

public $validationMessages;

/** 
 * Les champs nom, prénom, numéro, équipe, région_id, sexe, naissance sont requis
 * Les champs téléphone, nom_parent et adresse ne le sont pas
 */

public function validationRules() {
	return [
		'nom' => 'required|string',
		'prenom' => 'required|string',
        'numero' => 'required|integer',
        'equipe' => 'required|boolean',
        'region_id' => 'required|integer',
        'sexe' => 'required|boolean',
        'naissance' => 'required|date'
		];
}


}