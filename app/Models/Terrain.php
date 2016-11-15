<?php
/**
 * La classe Terrain
 * 
 * 
 * @author FUZZ
 * @version 0.1
 */

namespace App\Models;

class Terrain extends EloquentValidating {
    protected $guarded = array('id');


    /**
     * Eloquent relationship: un terrain peut supporter plusieurs sports différents
    */

    public function sports() {
        return $this->belongsToMany('App\Models\Sport');
    }

    public function region() {
        return $this->belongsTo('App\Models\Region');
    }
    
    /**
     * Eloquent relationship: un terrain est associée à plusieurs épreuves
     */
    public function epreuves()
    {
    	return $this->belongsToMany('App\Models\Epreuve');
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
