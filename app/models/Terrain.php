<?php
/**
 * La classe Terrain
 * 
 * 
 * @author FUZZ
 * @version 0.1
 */
class Terrain extends EloquentValidating {
    protected $guarded = array('id');


    /**
     * Eloquent relationship: un terrain peut supporter plusieurs sports différents
     *
     * public function sports() {
     *     return $this->hasMany('Sport');
     * }
     * 
     * public function participants() {
     *    return $this->belongsToMany('Participant');
     * }
    */

/**
 * Validation
 *
 * un sport doit avoir:
 * - nom: obligatoire, et unique dans toute la table
 * - saison : obligatoire, e (été), ou h (hiver)
 * - tournoi : obligatoire, booléen
 * - Les autres champs sont falcultatifs.
 */

    public function validationRules() {
        return [
            'nom' => 'required|unique:terrains,nom'.($this->id ? ",$this->id" : '')
            ];
    }

}
