<?php
/**
 * La classe Code
 * 
 * 
 * @author Éric B
 * @version 0.1
 */
 
namespace App\Models;
 
class Code extends EloquentValidating {
	protected $guarded = array('id');


/**
 * Validation
 *
 * un code doit avoir:
 * - nom: obligatoire, et unique dans toute la table
 * - Les autres champs sont falcultatifs.
 */
 
public $validationMessages;

public function validationRules() {
	return [
		'nom' => 'required|unique:codes,nom'.($this->id ? ",$this->id" : '')
		];
}

}