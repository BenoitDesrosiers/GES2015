<?php
/**
 * @author Jessee
 * @version 0.0.2 rev 1
 */

namespace App\Models;

class Evenement extends EloquentValidating { //FIXME: devrait hériter directement de model puisque que la validation est fait par request dans le controlleur
	protected $guarded = array('id');

    /**
     * Eloquent relationship: un événement appartient à une épreuve
     */

    public function epreuve() {
        return $this->belongsTo('App\Models\Epreuve');
    }

    public function type() {
        return $this->hasOne('App\Models\TypeEvenement', 'id', 'type_id');
    }

    public function participants() {
        return $this->belongsToMany('App\Models\Participant');
    }
/**
 * Validation
 */

public $validationMessages; //FIXME: plus nécessaire

public function validationRules() { //FIXME: plus nécessaire
	return [];
}


}