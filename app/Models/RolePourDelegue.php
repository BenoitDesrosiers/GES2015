<?php
/**
 * La classe Role
 *
 *
 * @author SteveL
 * @version 0.1
 */

namespace App\Models;

class RolePourDelegue extends EloquentValidating {
    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'roles_pour_delegues';

    protected $guarded = array('id');

    /**
     * Eloquent relationship: un rôle de délégué à plusieurs délégués
     */

    public function delegues() {
        return $this->hasMany('App\Models\Delegue');
    }
    /**
     * Validation
     *
     * un rôle de délégué doit avoir:
     * - nom: obligatoire, et unique dans toute la table
     * - Les autres champs sont falcultatifs.
     */

    public $validationMessages;

    public function validationRules() {
        return [
            'nom' => 'required|unique:roles_pour_delegues,nom'.($this->id ? ",$this->id" : '')
        ];
    }

}