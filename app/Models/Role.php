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
     * Eloquent relationship: un rôle d'usager a 0 ou plusieurs usagers.
     *
     * @return User[]
     */

    public function Usagers() {
        return $this->belongsToMany('App\Models\Role', 'role_user', 'role_id', 'user_id');
    }

    /**
     * Eloquent relationship: un rôle d'usager a 0 ou plusieurs permissions
     *
     * @return Permission[]
     */

    public function Permissions() {
        return $this->belongsToMany('App\Models\Permission', 'permission_role', 'role_id', 'permission_id');
    }


    /**
     * Validation
     *
     * Un rôle de délégué doit avoir:
     * - name: obligatoire, et unique dans toute la table
     * - Les autres champs sont falcultatifs.
     */

    public $validationMessages;

    public function validationRules() {
        return [
            'name' => 'required|unique:roles,name'.($this->id ? ",$this->id" : '')
        ];
    }
}