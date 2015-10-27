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
    */

    public function sports() {
        return $this->belongsToMany('Sport');
    }

    public function region() {
        return $this->belongsTo('Region');
    }

/**
 * Validation
 *
 * un terrain doit avoir:
 * - nom: obligatoire, et unique dans toute la table
 * - adresse : obligatoire
 * - ville : obligatoire
 * - region : obligatoire
 */

    public $validationMessages;

    public function validationRules() {
        return [
            'nom' => 'required|unique:terrains,nom'.($this->id ? ",$this->id" : ''),
            'adresse' => 'required',
            'ville' => 'required',
            'region_id' => 'required'
            ];
    }

}
