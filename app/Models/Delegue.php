<?php
/**
 * La classe Delegue
 *
 *
 * @author SteveL, Marc P
 * @version 0.1
 */

namespace App\Models;

class Delegue extends EloquentValidating {
    protected $guarded = array('id');

    /**
     * Eloquent relationship: Un délégué appartient à une région.
     */
    public function region() {
        return $this->belongsTo('App\Models\Region');
    }

    /**
     * Eloquent relationship: Un délégué peut avoir entre 0 et plusieurs rôles.
     *
     * @return rolesPourDelegue[]
     */
    public function rolesPourDelegues() {
        return $this->belongsToMany('App\Models\RolesPourDelegue', 'delegues_roles_pour_delegues', 'delegue_id', 'role_pour_delegue_id');
    }

    /**
     * La liste des id des rôles de ce délégué.
     *
     * @return int[]
     */
    public function idRoles() { //FIXME: Cette fonction ne devrait pas exister, le délégué ne devrait pas exposer la structure des des roles.  Faudrait changer le code qui s'en sert.
        $idRoles = [];
        foreach($this->rolesPourDelegues() as $role) {
            $idRoles[] = $role->id;
        }
        return $idRoles;
    }

    /**
     * Le nombre total de rôles pour ce délégué.
     *
     * @return int Le nombre de rôles.
     */
    public function nombreRoles() {
        return $this->rolesPourDelegues()->count();
    }


    /**
     * Un délégué a plusieurs courriels.
     *
     * @author Marc P
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courriels() {
        return $this->hasMany('App\Models\DelegueCourriel');
    }

    /**
     *
     * Un délégué a plusieurs téléphones.
     *
     * @author Marc P
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function telephones() {
        return $this->hasMany('App\Models\DelegueTelephone');
    }


    /**
     * Validation
     *
     * un délégué doit avoir obligatoirement:
     * - nom: string
     * - prenom: string
     * - region_id: integer
     * - sexe: bit
     * - accreditation: bit
     * - date_naissance: date
     *
     * un délégué peut avoir (optionnel):
     * - adresse: string
     * - telephone: string
     * - courriel: string
     */

    public $validationMessages;

    public function validationRules() {
        return [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'region_id' => 'required|integer',
            'accreditation' => 'required|boolean',
            'sexe' => 'required|boolean',
            'date_naissance' => 'required|date',
            'adresse' => 'string'
        ];
    }
}