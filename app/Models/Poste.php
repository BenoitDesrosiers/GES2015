<?php
/**
 * La classe Poste.
 *
 * @author Nicolas Bisson (ProgBiss)
 */

namespace App\Models;

class Poste extends EloquentValidating {
    protected $guarded = array('id');

    /**
     * Eloquent relationship: un poste a plusieurs bénévoles
     */

    public function benevoles() {
        return $this->hasMany('App\Models\Benevole');
    }
    /**
     * Validation
     *
     * un poste doit avoir:
     * - nom: obligatoire, et unique dans toute la table
     * - Les autres champs sont falcultatifs.
     */

    public $validationMessages;

    public function validationRules() {
        return [
            'nom' => 'required|unique:roles,nom'.($this->id ? ",$this->id" : '')
        ];
    }

}