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
     * Eloquent relationship: une permission a 0 ou plusieurs rôles.
     *
     * @return Role[]
     */

    public function roles() {
        return $this->belongsToMany('App\Models\Role', 'permission_role', 'permission_id', 'role_id');
    }

    /**
     * Validation
     *
     * Une permission doit avoir:
     * - name: obligatoire, et unique dans toute la table
     * - Les autres champs sont falcultatifs.
     */

    public $validationMessages;

    public function validationRules() {
        return [
            'name' => 'required|unique:permissions,name'.($this->id ? ",$this->id" : '')
        ];
    }
}