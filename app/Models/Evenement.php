<?php
/**
 * @author Jessee
 * @version 0.0.2 rev 1
 */

namespace App\Models;

class Evenement extends EloquentValidating {
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

/**
 * Validation
 */

public $validationMessages;

public function validationRules() {
	return [];
}


}