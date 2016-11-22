<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 2016-11-22
 * Time: 10:02
 */

namespace App\Models;


use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $guarded = array('id');

    /**
     * Eloquent relationship: un rôle d'usager à plusieurs délégués
     */

    public function Usagers() {
        return $this->hasMany('App\User');
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
            'name' => 'required|unique:roles,name'.($this->id ? ",$this->id" : '')
        ];
    }
}