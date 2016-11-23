<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 2016-11-22
 * Time: 10:02
 */

namespace App\Models;


use Zizaco\Entrust\EntrustRole;
use Zizaco\Entrust\Traits\EntrustRoleTrait;

class Role extends EntrustRole
{
    use EntrustRoleTrait;

    protected $guarded = array('id');

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