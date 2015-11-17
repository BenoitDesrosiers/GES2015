<?php
/**
 * La classe Role
 * 
 * 
 * @author SteveL
 * @version 0.1
 */
 
namespace App\Models;
 
class Role extends EloquentValidating {
	protected $guarded = array('id');


/**
 * Validation
 *
 * un rôle doit avoir:
 * - nom: obligatoire, et unique dans toute la table
 * - Les autres champs sont falcultatifs.
 */
 
public $validationMessages;

public function validationRules() {
	return [
		'nom' => 'required|unique:roles,nom'.($this->id ? ",$this->id" : '')
		];
}

}