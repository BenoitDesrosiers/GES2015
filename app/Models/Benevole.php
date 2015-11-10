<?php
/**
 * La classe Bénévole
 * 
 * 
 * @author dada
 * @version 0.1
 */

namespace App\Models;

class Benevole extends EloquentValidating {
	protected $guarded = array('id');

    /**
     * Validation
     *
     * un bénévole doit avoir:
     * - nom: obligatoire, string
     * - adresse : obligatoire, string
     * - telephone : obligatoire, string
     * - accreditation : obligatoire, string
     * - Les périodes de disponibilité et l'accréditation n'est pas
     *   obligatoire pour l'ajout d'un bénévole.
     */

    public function validationRules() {
	    return [
		    'nom' => 'required',
            'prenom' => 'required',
     		'adresse' => 'required',
            'numTel' => 'required|string',
		    'accreditation' => 'required'
		    ];
    }

}
