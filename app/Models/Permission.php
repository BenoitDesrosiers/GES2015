<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 2016-11-22
 * Time: 10:05
 */

namespace App\Models;


use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $guarded = array('id');

    /**
     * Eloquent relationship: un rôle de délégué à plusieurs délégués
     */

    public function roles() {
        return $this->hasMany('App\Models\Role');
    }
    /**
     * Validation
     *
     * Une permission doit avoir:
     * - nom: obligatoire, et unique dans toute la table
     * - Les autres champs sont falcultatifs.
     */

    public $validationMessages;

    public function validationRules() {
        return [
            'name' => 'required|unique:permissions,name'.($this->id ? ",$this->id" : '')
        ];
    }
}