<?php
/**
 * La classe Disponibilité
 * 
 * 
 * @author dada
 * @version 0.1
 */

namespace App\Models;

class Disponibilité extends EloquentValidating {
	protected $guarded = array('id');

    /** 
     * Eloquent relationship: une disponibilité appartient à un bénévole
     */
    public function benevole() {
	    return $this->belongsTo('Benevole');
    }

    /**
     * Validation
     *
     * une disponibilité doit avoir:
     * - commentaire : string
     * - heure_debut : obligatoire, datetime
     * - heure_fin : obligatoire, datetime
     */

    public function validationRules() {
	    return [
            'heure_debut' => 'required|datetime',
		    'heure_fin' => 'required|datetime'
		    ];
    }

}
